<?php

namespace Auth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
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
                'AuthService' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'email', 'password', 'MD5(?)');

                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);

                    return $authService;
                },
                'BaseFilter' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    return new \Auth\Form\Register\Filter\BaseFilter($dbAdapter);
                },
                'IndividualFilter' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    return new \Auth\Form\Register\Filter\IndividualFilter($dbAdapter);
                },
                'LegalFilter' => function($sm) {
                    $dbAdapter = $sm->get('DbAdapter');
                    return new \Auth\Form\Register\Filter\LegalFilter($dbAdapter);
                },
                'logged_in_user_id' => function ($sm) {
                    $authService = $sm->get('zend_auth_service');
                    $userId = $authService->getStorage()->read();
                    return isset($userId) ? $userId : 0;
                },
                'zend_auth_service' => function ($sm) {
                    $dbAdapter = $sm->get('zend_db_adapter');
                    $dbTableAuthAdapter = new \Zend\Authentication\Adapter\DbTable($dbAdapter, 'user', 'email', 'password', ''); // md5(?)
                    $authService = new \Zend\Authentication\AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    return $authService;
                },
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'UserHelper' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\Userhelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
            )
        );
    }

}
