<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Banner\Controller\Banner' => 'Banner\Controller\BannerController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'banner' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/banner[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Banner\Controller\Banner',
                        'action'     => 'index',
                    ),
                ),
            ), 
        ),
    ),
   'service_manager' => array(
        'factories' => array(
        ),
   ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Banner' => __DIR__ . '/../view',
        ),
    ),
);