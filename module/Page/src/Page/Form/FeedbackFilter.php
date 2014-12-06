<?php

namespace Page\Form;

use Zend\InputFilter\InputFilter;

class FeedbackFilter extends InputFilter {
    public function __construct() {

        $this->add(array(
            'name' => 'username',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'userdata',
            'required' => true,
        ));
        
        $this->add(array(
            'name' => 'text',
            'required' => true,
        ));
    }

}