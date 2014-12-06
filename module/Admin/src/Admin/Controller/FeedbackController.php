<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Page\Model\FeedbackTable;

class FeedbackController extends AbstractActionController {
	
	public function indexAction() {
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('DbAdapter');

		$feedbackTable = new FeedbackTable($dbAdapter);

		return new ViewModel(array('feedbacks' => $feedbackTable->fetchAll()));
	}

}