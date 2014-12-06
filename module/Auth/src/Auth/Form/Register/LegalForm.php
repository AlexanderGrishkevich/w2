<?php

namespace Auth\Form\Register;

use Zend\Form\Form,
    Zend\Captcha,
    Auth\Form\Register\IndividualForm;


class LegalForm extends IndividualForm {
    public function __construct($name = 'legal-register-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'register-form');

		$this->add(array(
            'name' => 'org_name',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'ООО "АРДФО"'
            ),
            'options' => array(
                'label' => "Наименование юридического лица",
            ),
        ));

        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'директор'
            ),
            'options' => array(
                'label' => "Должность представителя",
            ),
        ));

    }
}