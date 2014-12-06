<?php

namespace Auth\Form\Password;

use Zend\Form\Form;

class ChangePasswordForm extends Form {
    public function __construct($name = null) {
        parent::__construct('change-password-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'change-password-form');

        $this->add(array(
            'name' => 'old_password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => "Старый пароль",
            ),
        ));

        $this->add(array(
            'name' => 'new_password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => "Новый пароль",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сменить',
                'class' => 'submit'
            ),
        ));
    }
}