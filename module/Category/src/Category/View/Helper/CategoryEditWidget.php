<?php

namespace Category\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;

class CategoryEditWidget extends AbstractHelper {

    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($categoryId) {
        $sm = $this->sm;

        $categoryId = (int) $categoryId;
        
        $categoryTable = $sm->get('category_table');
        $category = $categoryTable->getCategoryById($categoryId);
        
        $form = $sm->get('Category\Form\CategoryForm');
        
        $form->bind($category);
        
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
