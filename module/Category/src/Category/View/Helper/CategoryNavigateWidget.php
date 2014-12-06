<?php

namespace Category\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;

class CategoryNavigateWidget extends AbstractHelper {

    protected $viewTemplate;
    protected $sm;

    public function __construct(\Zend\ServiceManager\ServiceManager $sm) {
        $this->sm = $sm;
    }

    public function __invoke($selectedCategory) {
        $sm = $this->sm;

        $categoryTable = $sm->get('category_table');

        $categories = $categoryTable->getChildrenCategories($selectedCategory);

        $view = new ViewModel(
                array(
            'categories' => $categories,
        ));

        $view->setTemplate($this->viewTemplate);

        return $this->getView()->render($view);
    }

    public function setViewTemplate($viewTemplate) {
        $this->viewTemplate = $viewTemplate;
        return $this;
    }
}
