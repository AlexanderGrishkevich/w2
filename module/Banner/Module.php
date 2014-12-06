<?php

namespace Banner;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
     
    public function getServiceConfig() {
        return array(
            'factories'=>array(
     
            ),
        );
    }

    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'SimpleBanners' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\SimpleBannerHelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'SaleBanners' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\SaleBannerHelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'VipBanners' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\VipBannerHelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                },
                'FooterBanners' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\FooterBannerHelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                }, 
                'MainBanners' => function ($helperPluginManager) {
                    $serviceLocator = $helperPluginManager->getServiceLocator();
                    $viewHelper = new View\Helper\MainBannerHelper();
                    $viewHelper->setServiceLocator($serviceLocator);
                    return $viewHelper;
                } 
            )
        );  
    }   

}