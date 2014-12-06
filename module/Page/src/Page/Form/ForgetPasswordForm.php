<?php

namespace Page\Form;

use Zend\Form\Form,
    Zend\Captcha;

class ForgetPasswordForm extends Form {
    public function __construct($name = null) {
        parent::__construct('forget-password-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'forget-password-form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Введите ваш адрес электронной почты, указанный при регистрации',
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