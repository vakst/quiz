<?php

namespace Words\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends Controller
{
  const TRANSLATIONS_PER_WORD = 3;
  const MAX_MISTAKE_COUNT = 3;

  protected $word = null;
  protected $user = null;
  protected $translation = null;
  protected $error = null;


  public function indexAction()
  {
    return $this->render('WordsQuizBundle:Quiz:index.html.twig');
  }
	
  public function getQuestionAction(Request $request)
  {
    $this->loadCurrentQuestion($request);
    if ($this->error !== null) {
      return new JsonResponse(array('status' => 'error', 'message' => $this->error));
    }
        
    //Result will be reproducible on equal user and question
    $wrongTranslationList = $this->getDoctrine()
      ->getManager()
      ->getRepository('WordsQuizBundle:Word')
      ->getWrongTranslationByWordId($this->word->getId(), $this->translation->getLanguage()->getId(), $this->word->getId(), self::TRANSLATIONS_PER_WORD);
    
    $translationList = array();
    foreach ($wrongTranslationList as $wrongTranslation) {
      $translationList[] = array('id' => $wrongTranslation->getId(), 'name' => $wrongTranslation->getName());
    }        
    $translationList[] = array('id' => $this->translation->getId(), 'name' => $this->translation->getName());

    //randomize
    shuffle($translationList);

    return new JsonResponse(
      array(
        'status' => 'success',
        'word' => $this->word->getName(),
        'translationList' =>  $translationList
        )
    );
  }

  public function answerQuestionAction(Request $request)
  {
    $this->loadCurrentQuestion($request);
    $result = null;
    if ($this->error === null) {
      if ($request->getMethod() == 'POST') {    
          $answerId = $request->request->get('answer');
          if ($this->translation->getId() == $answerId) {
            $this->user->setScore($this->user->getScore()+1);
            $this->user->setCurrentQuestionOffset($this->user->getCurrentQuestionOffset()+1);

            try {
              $em = $this->getDoctrine()->getManager();
              $em->persist($this->user);
              $em->flush();
              $result = array('status' => 'success', 'message' => 'answer correct');
            } catch (\Exception $e) {
              $this->error = 'internal_error';
            }
          } else {
            try {
              $mistakeWord = $this->getDoctrine()
                ->getManager()
                ->getRepository('WordsQuizBundle:Word')
                ->findOneById($answerId);

              $userTranslationMistakeLog = new \Words\QuizBundle\Entity\UserTranslationMistakeLog();
              $userTranslationMistakeLog->setUser($this->user);
              $userTranslationMistakeLog->setWord($this->word);
              $userTranslationMistakeLog->setTranslation($mistakeWord);

              $em = $this->getDoctrine()->getManager();
              $em->persist($userTranslationMistakeLog);
              $em->flush();
            } catch (\Exception $e) {
              $this->error = $e->getMessage();
            }

            $this->error = 'wrong_answer';
          }
      } else {
        $this->error = 'no_data';
      }
    }

    if ($this->error !== null) {
      return new JsonResponse(array('status' => 'error', 'message' => $this->error));
    } else {
      return new JsonResponse($result);
    }
  }

  public function getResultAction(Request $request)
  {
    $session = $request->getSession();
    if (
      $session->get('user_id')
      && ($this->user = $this->getDoctrine()->getManager()->getRepository('WordsQuizBundle:User')->findOneById($session->get('user_id')))
    ) {
      return new JsonResponse(array('status' => 'success', 'score' => $this->user->getScore()));
    } else {
      return new JsonResponse(array('status' => 'error', 'message' => 'auth_required'));
    }
  }

  protected function loadCurrentQuestion(Request $request)
  {
    $session = $request->getSession();
    if (
      $session->get('user_id')
      && ($this->user = $this->getDoctrine()->getManager()->getRepository('WordsQuizBundle:User')->findOneById($session->get('user_id')))
    ) {



      $mistakeCount = $this->getDoctrine()->getManager()->getRepository('WordsQuizBundle:UserTranslationMistakeLog')->getMistakeCountByUser($this->user->getId());
      if ($mistakeCount > self::MAX_MISTAKE_COUNT) {
        $this->error = 'mistakes_limit';
        return false;
      }

      //Get current question for user 
      if ($this->word = $this->getDoctrine()
        ->getManager()
        ->getRepository('WordsQuizBundle:Word')
        ->getNextEntityByUserId(
          $this->user->getId(),
          $this->user->getCurrentQuestionOffset()
        )
      ) {
        //Get right translation for this word 
        $this->translation = $this->getDoctrine()
          ->getManager()
          ->getRepository('WordsQuizBundle:Word')
          ->getTranslationByWordId($this->word->getId());
      } else {
        $this->error = 'no_more_questions';
      }
    } else {
      $this->error = 'auth_required';
    }
  }
}
