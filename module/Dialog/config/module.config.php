<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Dialog\Controller\Dialog' => 'Dialog\Controller\DialogController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dialog' => array(
                'type' => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/dialog[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        'controller' => 'Dialog\Controller\Dialog',
                        'action' => 'index',
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
            'Dialog' => __DIR__ . '/../view',
        ),
    ),
);
