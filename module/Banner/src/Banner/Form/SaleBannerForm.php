<?php

namespace Banner\Form;

use Zend\Form\Form;

use Banner\Form\BannerForm;

class SaleBannerForm extends BannerForm {
    public function __construct($name = 'sale-banner-add-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'sale-banner-add-form');

        $this->add(array(
            'name' => 'discount',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => ''
            ),
            'options' => array(
                'label' => "Процент скидки",
            ),
        ));
    }
}