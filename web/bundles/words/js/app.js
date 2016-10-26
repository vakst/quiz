var app = angular.module('wordsApp', ['ngRoute', 'toaster']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
        when('/start', {
            title: 'Start test',
            templateUrl: '/bundles/words/js/template/start.html',
            controller: 'authCtrl',
            authRequired: false
        })
        .when('/quiz', {
            title: 'Quiz',
            templateUrl: '/bundles/words/js/template/quiz.html',
            controller: 'quizCtrl',
            authRequired: true
        })
        .when('/result', {
            title: 'Result',
            templateUrl: '/bundles/words/js/template/result.html',
            controller: 'quizCtrl',
            authRequired: true
        })
        .when('/', {
            title: 'Quiz',
            templateUrl: '/bundles/words/js/template/quiz.html',
            controller: 'quizCtrl',
            authRequired: true
        })
        .otherwise({
            redirectTo: '/start'
        });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('isLogged').then(function (results) {
                if (results.result) {
                    $rootScope.authenticated = true;
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/start') {
                        $location.path("/quiz");
                    }
                } else {
                    if (next.$$route.authRequired === true) {
                        $location.path("/start");
                    }
                }
            });
        });
    });


//Controller

app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {

    $scope.login = {};
    $scope.doLogin = function (user) {
        Data.post('logIn', user).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('quiz');
            }
        });
    };
});

app.controller('quizCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    $scope.quiz = {};

    $scope.init = function() {
        $scope.isProcessing = true;
        Data.get('getQuestion').then(function (results) {
            $scope.isProcessing = false;
            if (results.status == 'success') {
                $scope.word = results.word;
                $scope.translationList = results.translationList;
            } else {                
                if (results.message == 'no_more_questions') {
                    $location.path("/result");
                } else if (results.message == 'mistakes_limit') {
                    $location.path("/result");
                } else {
                    Data.toast(results);
                }
            }
        });
    }

    $scope.answerQuestion = function(answer) {
        $scope.isProcessing = true;
        Data.post('answerQuestion', answer).then(function (results) {
            $scope.isProcessing = false;
            Data.toast(results);
            if (results.status == 'success') {
                 $scope.init();
            } else {
                if (results.message == 'mistakes_limit') {
                    $location.path("/result");
                }
            }
        });
    }

    $scope.loadResult = function() {
        Data.post('getQuizResult').then(function (results) {
            if (results.status == 'success') {
                $scope.score = results.score
            }
        });
    }

    $scope.logout = function () {
        Data.get('logOut').then(function (results) {
            Data.toast(results);
            $location.path('start');
        });
    }    

});


app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) {

        var serviceBase = '/api/';

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 3000, 'trustedHtml');
        }
        obj.get = function (query) {
            return $http.get(serviceBase + query).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (query, object) {
            return $http.post(serviceBase + query, object).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);