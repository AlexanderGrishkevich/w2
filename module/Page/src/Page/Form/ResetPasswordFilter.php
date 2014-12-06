<?php

namespace Page\Form;

use Zend\InputFilter\InputFilter;

class ResetPasswordFilter extends InputFilter {
    public function __construct() {

        $this->add(array(
            'name' => 'newpass',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'confirm',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
        ));
    }
}