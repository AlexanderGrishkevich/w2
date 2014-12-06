<?php

namespace Auth\Form\Register\Filter;

use Auth\Form\Register\Filter\BaseFilter;

class IndividualFilter extends BaseFilter
{
    protected $dbAdapter;

    public function __construct($dbAdapter) {

        parent::__construct($dbAdapter);
        $this->dbAdapter = $dbAdapter;
        
        $this->add(array(
            'name' => 'zip',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'street',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'house',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'office',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'unp',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'egr_org',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'egr_num',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'egr_date',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'bank',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'bank_code',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'bank_address',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'bank_acc',
            'required' => true,
        ));
        
    }
}

