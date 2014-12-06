<?php
namespace Auth\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;
 
class Userhelper extends AbstractHelper {
    public function __invoke(){
        $this->authService = $this->serviceLocator->get('AuthService');
        if($this->authService->hasIdentity()){
            return $this->authService->getIdentity();
            //return $this->getView()->render('partial/login', array('getIdentity' => $this->authService->getIdentity()));
        }
        else {
            return false;
            //return $this->getView()->render('partial/login', array(''));
        }
        
    }

    public function setServiceLocator(ServiceManager $serviceLocator){
        $this->serviceLocator = $serviceLocator;
    }
}