<?php

namespace Page\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Page\Model\Feedback,
    Page\Form\ForgetPasswordForm,
    Page\Form\ForgetPasswordFilter,
    Auth\Model\UserTable,
    Auth\Model\User,
    Page\Model\ForgetPasswordTable,
    Page\Form\ResetPasswordForm,
    ArrayObject,
    Page\Form\ResetPasswordFilter;
use Zend\Mail;

class PasswordController extends AbstractActionController {
    
    public function forgetPasswordEmailAction() {
        return new ViewModel();
    }
    
    public function forgetAction() {
        $form = new ForgetPasswordForm();
        return new ViewModel(array('form' => $form));
    }

    public function processForgetAction() {
        $post = $this->request->getPost();
        $form = new ForgetPasswordForm();
        $form->setInputFilter(new ForgetPasswordFilter());
        $form->setData($post);

        if (!$form->isValid()) {
            $model = new ViewModel(array('error' => true, 'form' => $form));
            $model->setTemplate('page/password/forget');
            return $model;
        }

        $data = $form->getData();

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');

        $userTable = new UserTable($dbAdapter);
        $forgetPasswordTable = new ForgetPasswordTable($dbAdapter);

        $user = $userTable->getUserByEmail($data['email']);
        if ($user) {
            $code = substr(md5($user->id . $user->email . date('d.m.y H:i:s')), 0, 10);
            $forgetPasswordTable->save($user->id, $user->email, $code);
            $link = 'http://fortest.ardfo.by/password/reset-password?code=' . $code;
            $this->sendMail($link, $user->email, $user->first_name . ' ' . $user->last_name);
            return $this->redirect()->toRoute(NULL, array('controller' => 'Password', 'action' => 'forget-password-email'));
        } else {
            $model = new ViewModel(array('no_user' => 'Пользователя с данным email не существует', 'form' => $form));
            $model->setTemplate('page/password/forget');
            return $model;
        }
    }
    
    public function sendMail($link, $email, $name) {
        $options = new \Zend\Mail\Transport\SmtpOptions(array(
            "name" => "atservers",
            "host" => "ox20m.atservers.net",
            "connection_class" => "login",
            "port" => 587,
            "connection_config" => array(
                "username" => "Soulmar@user1156746.atservers.net",
                "password" => "?w&X+@ca7q"
            )
        ));
        
        $message = array();
        $message[] = 'Здравствуйте, ' . $name;
        $message[] = 'Для того чтобы сменить ваш пароль, пройдите по ссылке ' . $link;
        $message[] = 'Пожалуйста, проигнорируйте данное письмо, если оно попало к Вам по ошибке.';
        $message[] = '';
        $message[] = 'С уважением, Служба поддержки пользователей проекта Ardfo.By.';

        $htmlPart = new \Zend\Mime\Part(implode("<br>",$message));
        $htmlPart->type = "text/html";

        $body = new \Zend\Mime\Message();
        $body->setParts(array($htmlPart));

        $msg = new \Zend\Mail\Message();
        $msg->setFrom('no-reply@ardfo.by');
        $msg->addTo($email);
        $msg->setSubject('Смена пароля');
        $msg->setEncoding('UTF-8');
        $msg->setBody($body);
        
        $headers = $msg->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');

        $transport = new \Zend\Mail\Transport\Smtp();
        $transport->setOptions($options);
        try {
            $transport->send($msg);
        } catch (Exception $e) {

        }
    }
    
    public function resetPasswordAction() {
        $code = $this->params()->fromQuery('code');
        
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $forgetPassTable = new ForgetPasswordTable($dbAdapter);
        
        $record = $forgetPassTable->getByCode($code);
        if ($record) {
            $form = new ResetPasswordForm();
            $bind = new ArrayObject;
            $bind['code'] = $code;
            $form->bind($bind);
            return new ViewModel(array('form' => $form));
        }
        return $this->redirect()->toRoute('application');
    }
    
    public function processResetPasswordAction() {
        $post = $this->request->getPost();
        $form = new ResetPasswordForm();
        $form->setInputFilter(new ResetPasswordFilter());
        $form->setData($post);
        
        if (!$form->isValid()) {
            $model = new ViewModel(array('error' => true, 'form' => $form));
            $model->setTemplate('page/password/reset-password');
            return $model;
        }
        if ($post->newpass != $post->confirm) {
            $model = new ViewModel(array('bad_confirm' => 'Пароли не совпадают', 'form' => $form));
            $model->setTemplate('page/password/reset-password');
            return $model;
        }

        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $forgetPasswordTable = new ForgetPasswordTable($dbAdapter);
        $userTable = new UserTable($dbAdapter);
        
        $record = $forgetPasswordTable->getByCode($post->code);
        
        $user = new User();
        $user->exchangeArray(array('id' => $record->user_id, 'password' => $post->newpass));
        
        $userTable->updatePassword($user);
        $forgetPasswordTable->delete($post->code);
                
        return $this->redirect()->toRoute('application');
    }
    
}
