<?php

namespace Words\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Words\QuizBundle\Entity;

class AuthorizationController extends Controller
{

  public function isLoggedAction(Request $request)
  {
      $session = $request->getSession();
      $result = array('result' => false);
      if ($session->get('user_id')) {
        $result = array('result' => true);
      }

      return new JsonResponse($result);
  }

  public function logOutAction(Request $request)
  {
      $session = $request->getSession()->invalidate();
      return new JsonResponse(array('status' => 'success', 'message' => 'logout success'));
  } 

  public function logInAction(Request $request)
  {
      $result = array('status' => 'error');

      //Check is session already started
      $session = $request->getSession();
      if (!($userId = $session->get('user_id'))) {
        
        //Check data from form
        if ($request->getMethod() == 'POST') {    
          $name = $request->request->get('name');
        }

        if (!empty($name)) {
          $user = new \Words\QuizBundle\Entity\User();
          $user->setName($name);
          $user->setScore(0);
          $user->setCurrentQuestionOffset(0);

          try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $session->set('user_id', $user->getId());
            $result = array('status' => 'success', 'message' => 'SingIn success');
          } catch (Exception $e) {
            $result['message'] = 'internal_error';
          }

        } else {
          $result['message'] = 'invalid_request';
        }

      } else {
        $result['message'] = 'already_started';
      }

      return new JsonResponse($result);
  } 
}