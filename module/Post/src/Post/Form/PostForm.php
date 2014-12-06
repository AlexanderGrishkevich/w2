<?php

namespace Post\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PostForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Post');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'post-add');
        $this->setAttribute('action', '/post/edit');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'user_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control title',
                'required' => 'required',
                'placeholder' => ' Название темы',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "Введите заголовок",
            ),
        ));

        $this->add(array(
            'name' => 'text',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control desc',
                'required' => 'required',
                'placeholder' => 'Описание темы',
            ),
            'options' => array(
                'label' => "Введите текст",
            ),
        ));

        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control price',
                'placeholder' => 'Цена у.е.',
                'maxlength' => 10,
            ),
            'options' => array(
                'label' => "Цена",
            ),
        ));

        $this->add(array(
            'name' => 'chaffer',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => "Договорная",
                'use_hidden_element'=> true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ),
        ));
        
        $this->add(array(
            'name' => 'tags',
            'attributes' => array(
                'type' => 'textarea',
                'class' => 'form-control tags',
                'placeholder' => 'Введите сопровождающие теги, например: #авто #москвич #прицеп',
            ),
            'options' => array(
                'label' => "Введите сопровождающие теги",
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Сохранить',
                'class' => 'btn btn-lg submit',
            ),
        ));
    }
}
