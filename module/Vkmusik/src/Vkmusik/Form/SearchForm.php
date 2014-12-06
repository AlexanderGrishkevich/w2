<?php

namespace Vkmusik\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SearchForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Comment');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'user_id',
            'type' => 'Hidden',
        ));
        
         $this->add(array(
            'name' => 'post_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'text',
                'class' => 'msg-text',
                'required' => 'required',
                'placeholder' => 'Ваш комментарий',
            ),
            'options' => array(
                'label' => "Введите текст",
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