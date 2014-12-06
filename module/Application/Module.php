<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\View\Model\ViewModel;

class Module
{
    public function onBootstrap(MvcEvent $e) {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->setDefaultTranslator($e);
        $this->initAcl($e);
        $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this,'onDispatchError'), 100); 
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onDispatchError(MvcEvent $event) {
        $error = $event->getError();

        if (empty($error) || $error != 'ACL_ACCESS_DENIED') {
            return;
        }

        $exceptionstrategy = $event->getApplication()->getServiceManager()->get('ViewManager')->getExceptionStrategy();
        $exceptionstrategy->setExceptionTemplate('error/403');
    }

    protected function setDefaultTranslator($e) {
        $translator = $e->getApplication()->getServiceManager()->get('translator');

        $type = 'phpArray';
        $filename = 'data/language/ru/Zend_Validate.php';
        $textDomain = 'default';
        $locale = 'ru_RU';

        $translator->addTranslationFile($type, $filename, $textDomain, $locale);

        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function initAcl(MvcEvent $e) {
        $acl = new \Zend\Permissions\Acl\Acl();
        $roles = include __DIR__ . '/config/module.acl.roles.php';

        $allResources = array();
        foreach ($roles as $role => $resources) {
     
            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            $acl->addRole($role);
     
            $allResources = array_merge($resources, $allResources);
     
            //adding resources
            foreach ($resources as $resource) {
                 if(!$acl->hasResource($resource))
                    $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
            }
            //adding restrictions
            foreach ($allResources as $resource) {
                $acl->allow($role, $resource);
            }
        }

        $e->getViewModel()->acl = $acl;
    }

    public function checkAcl(MvcEvent $e) {
        $route = $e->getRouteMatch()->getMatchedRouteName();
        $action = $e->getRouteMatch()->getParam('action');
        $user = $e->getApplication()->getServiceManager()->get('AuthService')->getIdentity();

        if(!$user) {
            $userRole = 0;
        }
        else {
            $userRole = $user['role'] != '' ? $user['role'] : 0;
        }
        //TODO refactor this
        if ($userRole == 2 || $userRole == 3 ) {
            if (($route == 'post' && $action == 'add') || ($route == 'banner' && $action == 'index')) {
                $dbAdapter = $e->getApplication()->getServiceManager()->get('DbAdapter');
                $userTable = new \Auth\Model\UserTable($dbAdapter);
                $userFromDb = $userTable->getUser($user['id']);

                if (time() > $userFromDb->off_date) {
                    $e->setError('ACL_ACCESS_DENIED')->setParam('route', $route);
                    $e->getTarget()->getEventManager()->trigger('dispatch.error', $e);
                    return;
                }
            }
        }

        if ($e->getViewModel()->acl->hasResource($route) && !$e->getViewModel()->acl->isAllowed($userRole, $route)) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . '/404');
            $response->setStatusCode(404);
        }
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'UserWidget' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\UserWidget();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'ControllerName' => function ($sm) {
                   $match = $sm->getServiceLocator()->get('application')->getMvcEvent()->getRouteMatch();
                   $viewHelper = new \Application\View\Helper\ControllerName($match);
                   return $viewHelper;
                },
                'Thumb' => function ($helperPluginManager) {
                    $viewHelper = new View\Helper\Thumb();
                    return $viewHelper;
                },              
            )
        );  
    }    

}
