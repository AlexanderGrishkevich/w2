<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Database\Controller\Database' => 'Database\Controller\DatabaseController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Database' => __DIR__ . '/../view',
        ),
    ),
//    'doctrine' => array(
//        'driver' => array(
//            'w2base_module_entities' => array(
//                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
//                'cache' => 'array',
//                'paths' => array(__DIR__ . '/../src/W2Base/Model')
//            ),
//            'orm_default' => array(
//                'drivers' => array(
//                    'W2Base\Model' => 'w2base_module_entities'
//                )
//            )
//        )
//    ),
    'router' => array(
        'routes' => array(
            'database' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/database[/][:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Database\Controller\Database',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
//                'child_routes' => array(
//                    'info' => array(
//                        'type' => 'segment',
//                        'may_terminate' => true,
//                        'options' => array(
//                            'route' => '/info[/][:action]',
//                            'constraints' => array(
//                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                                'controller' => 'W2Base\Controller\W2Base',
//                                'action' => 'index',
//                            ),
//                        ),
//                    ),
//                ),
            ),
        ),
    ),
);
