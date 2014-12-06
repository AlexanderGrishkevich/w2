<?php

namespace Auth\Form\Register\Filter;

use Zend\InputFilter\InputFilter;

class BaseFilter extends InputFilter
{
    protected $dbAdapter;

    public function __construct($dbAdapter) {

        $this->dbAdapter = $dbAdapter;

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 140,
                    ),
                ), array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ), array(
                    'name' => 'Db\NoRecordExists',
                    'options' => array(
                        'table' => 'users',
                        'field' => 'email',
                        'adapter' => $this->dbAdapter,
                        'messages' => array(
                            \Zend\Validator\Db\NoRecordExists::ERROR_RECORD_FOUND => 'Этот email уже зарегистрирован',
                        ),
                    ),
                ),                
            ),
        ));

        $this->add(array(
            'name' => 'password',
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
            'name' => 'last_name',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'first_name',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'middle_name',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'country',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'city',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'region',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'phone',
            'required' => false,
        ));
        
        $this->add(array(
            'name' => 'org_name',
            'required' => true,
        ));
    }

}