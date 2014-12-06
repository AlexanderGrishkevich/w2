<?php

namespace Category\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class FormWidget extends AbstractHelper {

    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($form) {
        $sm = $this->sm;


        $view = new ViewModel(
                array(
            'form' => $form,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
