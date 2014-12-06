<?php

namespace Category\Form;

use Zend\InputFilter\InputFilter;

class CategoryInputFilter extends InputFilter {

    public function __construct() {

        $this->add(array(
            'name' => 'title',
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'StripTags',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'parent_id',
            'required' => true,
        ));
    }
}
