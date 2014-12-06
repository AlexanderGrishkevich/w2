<?php

namespace Dialog\Form;

use Zend\Form\Form;

class DialogForm extends Form {
    
    public function __construct($name = null) {
        parent::__construct('send-msg-form'); // this name is not used 
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Введите ваше сообщение',
                'required' => 'required',
                'class' => 'msg-text',
                'autocomplete' => "off"
            ),
            'options' => array(
                'label' => "Text",
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Отправить',
                'class' => 'msg-submit',
            ),
        ));
    }
}