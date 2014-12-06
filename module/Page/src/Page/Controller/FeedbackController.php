<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Page\Form\FeedbackForm,
    Page\Form\FeedbackFilter,
    Page\Model\Feedback,
    Page\Model\FeedbackTable;

class FeedbackController extends AbstractActionController {

    public function feedbackAction() {
        $form = new FeedbackForm();
        return new ViewModel(array('form' => $form));
    }

    public function processFeedbackAction() {
        $post = $this->request->getPost();
        $form = new FeedbackForm();
        $form->setInputFilter(new FeedbackFilter());
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array('error' => true, 'form' => $form));
            $model->setTemplate('page/feedback/feedback');
            return $model;
        }

        $data = $form->getData();

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $feedback = new Feedback();
        $feedbackTable = new FeedbackTable($dbAdapter);
        $feedback->exchangeArray($data);
        $feedbackTable->save($feedback);
        return $this->redirect()->toRoute(NULL, array('controller' => 'feedback', 'action' => 'confirm-feedback'));
    }

    public function confirmFeedbackAction() {
        return new ViewModel();
    }

}
