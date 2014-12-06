<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Category\Controller\Category' => 'Category\Controller\CategoryController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route' => '/category[/][:action][/][:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        'controller' => 'Category\Controller\Category',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Category' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'category_module_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Category/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Category\Model' => 'category_module_entities'
                )
            )
        )
    ),
);
