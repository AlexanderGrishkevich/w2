<?php

namespace Application\Navigation;

use Zend\Navigation\Service\DefaultNavigationFactory;

class FooterNavigationFactory extends DefaultNavigationFactory {
    protected function getName() {
        return 'footer';
    }
}