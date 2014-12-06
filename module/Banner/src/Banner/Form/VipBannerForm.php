<?php

namespace Banner\Form;

use Zend\Form\Form;

use Banner\Form\BannerForm;

class VipBannerForm extends BannerForm {
    public function __construct($name = 'vip-banner-add-form') {

        parent::__construct($name); 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'vip-banner-add-form');

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '',
                'maxLength' => 20
            ),
            'options' => array(
                'label' => "Заголовок (20 символов)",
            ),
        ));
        
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => ''
            ),
            'options' => array(
                'label' => "Цена (у.е)",
            ),
        ));
    }
}