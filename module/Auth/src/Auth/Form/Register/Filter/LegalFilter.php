<?php

namespace Auth\Form\Register\Filter;

use Auth\Form\Register\Filter\IndividualFilter;

class LegalFilter extends IndividualFilter
{
    protected $dbAdapter;

    public function __construct($dbAdapter) {

        parent::__construct($dbAdapter);
        $this->dbAdapter = $dbAdapter;
        
        $this->add(array(
            'name' => 'position',
            'required' => true,
        ));
        
    }
}

