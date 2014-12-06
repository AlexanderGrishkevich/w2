<?php

namespace Page\Form;

use Zend\InputFilter\InputFilter;

class ForgetPasswordFilter extends InputFilter {
    public function __construct() {

        $this->add(array(
            'name' => 'email',
            'required' => true,
        ));
    }
}