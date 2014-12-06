<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Auth\Model\UserTable;

class UserController extends AbstractActionController {
	
	public function indexAction() {
		return new ViewModel();
	}

	public function searchUserAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$post = $this->request->getPost();

		$userTable = new UserTable($dbAdapter);
		$user = $userTable->getUserByUNP($post->unp);

		$response = $this->getResponse();
 		$response->setContent(json_encode($user, JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;			
	}

	public function activateUserAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');
		$post = $this->request->getPost();

		$answer = array('status' => 'bad');

		if($post->action != '' && $post->id != '' && $post->time != '') {
			if ($post->action == 'up') {
				$newTime = strtotime('+' . $post->time . ' months', time());
			} elseif ($post->action == 'down') {
				$newTime = strtotime('-' . $post->time . ' months', time());
			}

			$userTable = new UserTable($dbAdapter);
			$userTable->activateUser($post->id, $newTime);
			$answer = array('status' => 'ok');		
		}

		$response = $this->getResponse();
 		$response->setContent(json_encode($answer, JSON_UNESCAPED_UNICODE));
		$response->getHeaders()->addHeaderLine('Content-Type', 'application/json; charset=utf-8');
 		return $response;		
	}

}