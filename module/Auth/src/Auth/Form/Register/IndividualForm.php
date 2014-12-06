<?php

namespace Auth\Form\Register;

use Zend\Form\Form,
    Zend\Captcha,
    Auth\Form\Register\BaseForm;


class IndividualForm extends BaseForm {
    public function __construct($name = 'individual-register-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'register-form');

        $this->add(array(
            'name' => 'org_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'ИП Иванов Петр Михайлович'
            ),
            'options' => array(
                'label' => "Наименование юридического лица",
            ),
        ));

		$this->add(array(
            'name' => 'zip',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '220123'
            ),
            'options' => array(
                'label' => "Индекс",
            ),
        ));

        $this->add(array(
            'name' => 'street',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Воронянского'
            ),
            'options' => array(
                'label' => "Улица",
            ),
        ));

        $this->add(array(
            'name' => 'house',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '45-1'
            ),
            'options' => array(
                'label' => "Номер дома - корпус",
            ),
        ));

        $this->add(array(
            'name' => 'office',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '58'
            ),
            'options' => array(
                'label' => "Номер офиса, квартиры",
            ),
        ));     

        $this->add(array(
            'name' => 'unp',
            'attributes' => array(
                'type' => 'number',
                'placeholder' => '192000250'
            ),
            'options' => array(
                'label' => "УНП",
            ),
        ));

        $this->add(array(
            'name' => 'egr_org',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Администрация Первомайского района'
            ),
            'options' => array(
                'label' => "Орган, осуществивший регистрацию",
            ),
        ));

        $this->add(array(
            'name' => 'egr_num',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '734025'
            ),
            'options' => array(
                'label' => "Номер решения о государственной регистрации",
            ),
        ));

        $this->add(array(
            'name' => 'egr_date',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '08-10-2013'
            ),
            'options' => array(
                'label' => "Дата государствнной регистрации",
            ),
        ));

    	$this->add(array(
            'name' => 'bank',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'ОАО Беларусьбанк'
            ),
            'options' => array(
                'label' => "Банк",
            ),
        ));

        $this->add(array(
            'name' => 'bank_code',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '764'
            ),
            'options' => array(
                'label' => "Код банка",
            ),
        ));

        $this->add(array(
            'name' => 'bank_address',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'г.Минск, ул. Комсомольская, 13'
            ),
            'options' => array(
                'label' => "Адрес банка",
            ),
        ));

        $this->add(array(
            'name' => 'bank_acc',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '123456789632541'
            ),
            'options' => array(
                'label' => "Расчетный счет",
            ),
        ));

    }
}