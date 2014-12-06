<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Page\Controller\Page' => 'Page\Controller\PageController',
            'Page\Controller\Feedback' => 'Page\Controller\FeedbackController',
            'Page\Controller\Password' => 'Page\Controller\PasswordController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'page' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/page[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\Page',
                        'action' => 'company',
                    ),
                ),
            ),

            'feedback' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/feedback[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\Feedback',
                        'action'     => 'feedback',
                    ),
                ),
            ),
            'password' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/password[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Page\Controller\Password',
                        'action'     => 'password',
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
            'Page' => __DIR__ . '/../view',
        ),
    ),
);