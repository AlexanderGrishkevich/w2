<?php

namespace Page\Form;

use Zend\Form\Form,
    Zend\Captcha;

class FeedbackForm extends Form {
    public function __construct($name = null) {
        parent::__construct('login-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'feedback-form');

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => "Ваше имя",
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'userdata',
            'options' => array(
                'label' => 'Контакты',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'text',
            'options' => array(
                'label' => 'Сообщение',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Введите текст'
            ),
            'options' => array(
                'captcha' => new Captcha\Figlet(array(
                    'name' => 'foo',
                    'wordLen' => 4,
                    'timeout' => 300,
                    'messages' => array(
                        'badCaptcha' => 'Неправильно введена каптча!'
                    )
                )),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Отправить',
                'class' => 'feedback-submit'
            ),
        ));
    }
}