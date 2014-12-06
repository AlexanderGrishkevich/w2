<?php

namespace Category\Form;

use Zend\Form\Form;

class CategoryForm extends Form {

    public function __construct($name = null) {
        parent::__construct('category-add-form');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttribute('class', 'form-add-post');
        $this->setAttribute('action', '/category/process');

        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => ''
            ),
            'options' => array(
                'label' => "user_id",
            ),
        ));

        $this->add(array(
            'name' => 'category_id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => ''
            ),
            'options' => array(
                'label' => "category_id",
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'parent_id',
            'attributes' => array(
                'options' => array(),
            ),
            'options' => array(
                'label' => "parent_id",
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
//                'required' => 'required',
                'maxlength' => 70,
            ),
            'options' => array(
                'label' => "title",
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'class' => '',
            ),
            'options' => array(
                'label' => "description",
            ),
        ));
        
        $this->add(array(
            'name' => 'redirect',
            'attributes' => array(
                'type' => 'text',
                'readonly' => 'readonly',
                'class' => ''
            ),
            'options' => array(
                'label' => "redirect",
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'save',
                'class' => '',
            ),
            'options' => array(
                'label' => "save",
            ),
        ));
    }
}
