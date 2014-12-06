<?php

namespace Category;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'category_table_gateway' => function ($sm) {
                    $dbAdapter = $sm->get('zend_db_adapter');
                    $resultSetPrototype = new \Zend\Db\ResultSet\ResultSet;
                    $category = new \Category\Model\Category();
                    $resultSetPrototype->setArrayObjectPrototype($category);
                    $categotyTableGateway = new \Zend\Db\TableGateway\TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                    return $categotyTableGateway;
                },
                'category_table' => function ($sm) {
                    $categotyTableGateway = $sm->get('category_table_gateway');
                    $categoryTable = new \Category\Model\CategoryTable($categotyTableGateway);
                    return $categoryTable;
                },
                'Category\Form\CategoryForm' => function ($sm) {
                    $form = new \Category\Form\CategoryForm();

                    $inputFilter = new \Category\Form\CategoryInputFilter();
                    $form->setInputFilter($inputFilter);

                    $categoryTable = $sm->get('category_table');
                    $list = $categoryTable->getCategoryList();

                    $form->get('parent_id')->setAttribute('options', $list);
                    $form->get('redirect')->setAttribute('value', '/category/list');

                    return $form;
                },
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'categoryListWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator();
                    $widget = new \Category\View\Helper\CategoryListWidget($sm);
                    $widget->setViewTemplate('/helper/category/list');
                    return $widget;
                },
                'categoryEditWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator();
                    $widget = new \Category\View\Helper\CategoryEditWidget($sm);
                    $widget->setViewTemplate('/helper/category/edit');
                    return $widget;
                },
                'categoryNavigateWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator();
                    $widget = new \Category\View\Helper\CategoryNavigateWidget($sm);
                    $widget->setViewTemplate('/helper/category/view');
                    return $widget;
                },
                'formWidget' => function($viewHeplerManager) {
                    $sm = $viewHeplerManager->getServiceLocator();
                    $widget = new \Category\View\Helper\FormWidget($sm);
                    $widget->setViewTemplate('/helper/form/form');
                    return $widget;
                },
            ),
        );
    }

}
