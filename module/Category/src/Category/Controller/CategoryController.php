<?php

namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController {

    public function indexAction() {
        return $this->redirect()->toRoute("category", array('action' => 'list'));
    }

    public function listAction() {
        return array();
    }

    public function addAction() {
        $sm = $this->getServiceLocator();

        $userId = $sm->get('logged_in_user_id');

        $data = array(
            'user_id' => $userId,
            'create_date' => time(),
        );

        $categoryTable = $sm->get('category_table');

        $categoryEntity = new \Category\Model\Category($data);
        $categoryTable->saveCategory($categoryEntity);

        $savedCategory = $categoryTable->getLastUserCategory($userId);
        $savedCategoryId = $savedCategory->get('category_id');

        return $this->redirect()->toRoute('category', array('action' => 'edit',
                    'id' => $savedCategoryId));
    }

    public function editAction() {
        $categoryId = (int) $this->params()->fromRoute('id');

        return array(
            'categoryId' => $categoryId,
        );
    }

    public function processAction() {
        if (!$this->request->isPost()) {
            return $this->redirect()->toRoute('category', array('action' => 'add'));
        }

        $sm = $this->getServiceLocator();
        $userId = $sm->get('logged_in_user_id');

        $data = $this->request->getPost();

        //\Application\Log\Logger::info(json_encode($data));

        $form = $sm->get('Category\Form\CategoryForm');
        $form->setData($data);

        $categoryId = $data['category_id'];

        if (!$form->isValid()) { // todo valid form
            //\Application\Log\Logger::info('FORM CATEGORY NOT VALID');
            $formMessages = $form->getMessages();
            $this->flashMessenger()->setNamespace($form->getName())->addMessage($formMessages);
            return $this->redirect()->toRoute('category', array('action' => 'edit',
                    'id' => $categoryId));
        } else {
            $data['create_date'] = time();
            $data['user_id'] = $userId;

            $category = new \Category\Model\Category();
            $category->exchangeArray($data);

            $categoryTable = $sm->get('category_table');
            $categoryTable->saveCategory($category);

            $lastCategory = $categoryTable->getLastUserCategory($userId);
            $categoryId = $lastCategory->get('category_id');

            return $this->redirect()->toRoute('category', array('action' => 'list'));
        }
    }

    public function deleteAction() {
        $sm = $this->getServiceLocator();
        $categoryId = (int) $this->params()->fromRoute('id');
        $categoryTable = $sm->get('category_table');
        $categoryTable->deleteCategoryById($categoryId);
        return $this->redirect()->toRoute("category");
    }

}
