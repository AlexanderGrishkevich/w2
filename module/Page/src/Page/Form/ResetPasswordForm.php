<?php

namespace Page\Form;

use Zend\Form\Form;

class ResetPasswordForm extends Form {

    public function __construct($name = null) {
        parent::__construct('forget-password-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'reset-password-form');
        
        $this->add(array(
            'name' => 'code',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'newpass',
            'attributes' => array(
                'type' => 'text',
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Введите новый пароль',
            ),
        ));

        $this->add(array(
            'name' => 'confirm',
            'attributes' => array(
                'type' => 'text',
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Подтвердите ваш новый пароль',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Отправить',
                'class' => 'submit'
            ),
        ));
    }

}
