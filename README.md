Install
----------------------------------

1) If you don't have Composer yet, just run the following command:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer 
```

2) Checkout project from GitHub

```bash
cd <path-to-install>
git init
git remote add origin https://github.com/vakst/quiz.git
git pull origin master
```

3) Use the "composer install" command to install dependencies

```bash
composer install
```

4) Install Bower package

```bash
npm install -g bower
```

5) Install Angular package

```bash
bower install angular
bower install angular-route
bower install angularjs-toaster
```

6) Execute SQL from migration/initial.sql

7) Launch server

```bash
php bin/console server:run 127.0.0.1:8080
```