<?php

namespace Auth\Form\Register;

use Zend\Form\Form,
    Zend\Captcha;


class BaseForm extends Form {
    public function __construct($name = 'physical-register-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'register-form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'example@mail.com'
            ),
            'options' => array(
                'label' => "E-mail",
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
            'name' => 'last_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иванов'
            ),
            'options' => array(
                'label' => "Фамилия",
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иван'
            ),
            'options' => array(
                'label' => "Имя",
            ),
        ));
        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иванович'
            ),
            'options' => array(
                'label' => "Отчество",
            ),
        ));
        
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '+375172345678'
            ),
            'options' => array(
                'label' => "Контактный телефон",
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => "Страна",
                'disable_inarray_validator' => false
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'region',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => "Область, район",
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'city',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => "Населенный пункт",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Регистрация',
                'class' => 'submit'
            ),
        ));
        
        $this->add(array(
            'name' => 'org_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Иван Иванов'
            ),
            'options' => array(
                'label' => "Отображаемое имя",
            ),
        ));    
    }

}