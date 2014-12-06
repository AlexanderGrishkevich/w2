<?php

namespace Auth\Form\Password;

use Zend\InputFilter\InputFilter;

class ChangePasswordFilter extends InputFilter {
    public function __construct() {

        $this->add(array(
            'name' => 'old_password',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'new_password',
            'required' => true,
        ));
    }

}