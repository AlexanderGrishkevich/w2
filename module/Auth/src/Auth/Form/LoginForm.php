<?php

namespace Auth\Form;

use Zend\Form\Form;

class LoginForm extends Form {
    public function __construct($name = null) {
        parent::__construct('login-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'login-form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(
                'label' => "Email",
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => "Пароль",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Войти',
                'class' => 'submit'
            ),
        ));
    }
}