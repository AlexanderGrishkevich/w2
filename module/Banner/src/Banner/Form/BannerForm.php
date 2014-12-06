<?php

namespace Banner\Form;

use Zend\Form\Form;

class BannerForm extends Form {
    public function __construct($name = 'banner-add-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'banner-add-form');

        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'file',
            'options' => array(
                 'label' => 'Attachment:'
            ),
            'attributes' => array(
                'class' => 'banner-add-input',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class' => 'submit'
            ),
        ));
    }
}