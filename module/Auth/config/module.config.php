<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
            'Auth\Controller\Register' => 'Auth\Controller\RegisterController',
            'Auth\Controller\User' => 'Auth\Controller\UserController',
            'Auth\Controller\ChangePassword' => 'Auth\Controller\ChangePasswordController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/auth[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'register' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/register[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Register',
                        'action'     => 'showRegister',
                    ),
                ),
            ),
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\User'
                    ),
                ),
            ),
            'change-password' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/change-password[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Auth\Controller\ChangePassword',
                        'action' => 'index'
                    ),
                ),
            ),    
        ),
    ),
   'service_manager' => array(
        'factories' => array(
            'DbAdapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
   ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Auth' => __DIR__ . '/../view',
        ),
    ),
);