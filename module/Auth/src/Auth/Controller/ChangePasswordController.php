<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

use Auth\Model\UserTable,
    Auth\Model\User;

use Auth\Form\Password\ChangePasswordForm,
    Auth\Form\Password\ChangePasswordFilter;

class ChangePasswordController extends AbstractActionController {

    public function indexAction() {
        $form = new ChangePasswordForm();
        return new ViewModel(array('form' => $form));
    }

    public function processAction() {
        $sm = $this->getServiceLocator();
       $dbAdapter = $sm->get('DbAdapter');
        $currentUser = $sm->get('AuthService')->getIdentity();

        if(!$currentUser) {
            return $this->redirect()->toUrl('/register/show-register');
         }

        $post = $this->request->getPost();
        $form = new ChangePasswordForm();
        $form->setInputFilter(new ChangePasswordFilter());
        $form->setData($post);
        
        if (!$form->isValid()) {
            $model = new ViewModel(array('error' => true, 'form' => $form));
            $model->setTemplate('auth/change-password/index');
            return $model;
        }
        
        $userTable = new UserTable($dbAdapter);
        $currentUserData = $userTable->getUser($currentUser['id']);
        
        if (md5($post->old_password) != $currentUserData->password) {
            $model = new ViewModel(array('old_password_error' => 'Ввёдён не верный пароль', 'form' => $form));
            $model->setTemplate('auth/change-password/index');
            return $model;
        }

        $userTable->changePassword($currentUser['id'], $post->new_password);

        $this->redirect()->toUrl('/change-password/confirm');
    }
    
    public function confirmAction() {
        return new ViewModel();
    }

}