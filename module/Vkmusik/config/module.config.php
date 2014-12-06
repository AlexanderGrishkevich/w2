<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Vkmusik\Controller\Vkmusik' => 'Vkmusik\Controller\VkmusikController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'vkmusik' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/vkmusik[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Vkmusik\Controller\Vkmusik',
                        'action'     => 'index',
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