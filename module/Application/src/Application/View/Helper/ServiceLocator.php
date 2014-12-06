<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ServiceLocator extends AbstractHelper
{
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke()
    {
        if ($this->sm) {
            return $this->sm;
        }
    }

}