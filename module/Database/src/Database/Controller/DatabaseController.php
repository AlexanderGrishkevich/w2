<?php

namespace Database\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DatabaseController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function updateAction() {
        $sm = $this->getServiceLocator();

        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($classes);

        return $this->redirect()->toUrl('/admin/database');
    }

    public function createAction() {
        $sm = $this->getServiceLocator();

        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($classes);

        return $this->redirect()->toUrl('/admin/database');
    }

    public function dropAction() {
        $sm = $this->getServiceLocator();

        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($classes);

        return $this->redirect()->toUrl('/admin/database');
    }
}
