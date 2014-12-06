<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Post\Controller\Post' => 'Post\Controller\PostController',
            'Post\Controller\Attachment' => 'Post\Controller\AttachmentController',
            'Post\Controller\Like' => 'Post\Controller\LikeController',
            'Post\Controller\Comment' => 'Post\Controller\CommentController',
            'Post\Controller\Favorite' => 'Post\Controller\FavoriteController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'post' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/post[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Post',
                    ),
                ),
            ),
            'attachment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/attachment[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Attachment',
                    ),
                ),
            ),
            'like' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/like[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Like',
                    ),
                ),
            ),
            'comment' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/comment[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Comment',
                    ),
                ),
            ),
            'favorite' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/favorite[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Post\Controller\Favorite',
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
            'Post' => __DIR__ . '/../view',
        ),
    ),
);
