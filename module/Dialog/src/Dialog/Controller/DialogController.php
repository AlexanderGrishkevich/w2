<?php

namespace Dialog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Dialog\Model\DialogTable,
    Dialog\Form\DialogForm,
    Dialog\Model\Dialog;

class DialogController extends AbstractActionController {

    public function listAction() {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $dialogTable = new DialogTable($this->getServiceLocator()->get('dbAdapter'));
        $dialogs = $dialogTable->getDialogsByUserId($user['id']);
        return array(
            'userId' => $user['id'],
            'dialogs' => $dialogs
        );
    }

    public function openAction() {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        if (!$user['id']) {
            return $this->redirect()->toUrl('/register');
        }
        $secondUserId = (int) $this->params()->fromRoute('id');

        if (!$secondUserId || $secondUserId == $user['id']) {
            return $this->redirect()->toUrl('/dialog/list');
        }
        $dialogTable = new DialogTable($this->getServiceLocator()->get('dbAdapter'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $dialog = new Dialog;
            $text = $request->getPost()->text;
            $data = array(
                'sender_id' => $user['id'],
                'recipient_id' => $secondUserId,
                'text' =>  $text ? $text : 'what are you doing?',
                'create_date' => date("Y-m-d H:i:s"),
                'is_new' => 1,
            );
            $dialog->exchangeArray($data);
            $dialogTable->saveDialog($dialog);
        }

        $dialogs = $dialogTable->getDialogsByUsers($user['id'], $secondUserId);
        $dialogForm = new DialogForm();

        return array(
            'secondUserId' => $secondUserId,
            'userId' => $user['id'],
            'dialogs' => $dialogs,
            'dialogForm' => $dialogForm
        );
    }
    
    public function deleteAction()
    {
        $user = $this->getServiceLocator()->get('AuthService')->getIdentity();
        $secondUserId = (int) $this->params()->fromRoute('id');

        $dialogTable = new DialogTable($this->getServiceLocator()->get('dbAdapter'));
        $dialogTable->deleteUsersDialogs($user['id'], $secondUserId);
        return $this->redirect()->toUrl('/dialog/list');
    }

}
