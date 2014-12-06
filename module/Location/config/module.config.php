<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Location\Controller\Location' => 'Location\Controller\LocationController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'location' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/location[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Location\Controller\Location',
                        'action'     => 'get-country',
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
            'Location' => __DIR__ . '/../view',
        ),
    ),
);