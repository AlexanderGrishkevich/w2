<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'mainBanner',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'mainBanner',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Закладки',
                'route' => 'favorite',
                'action' => 'list',
                'resource' => 'favorite',
            ),
            array(
                'label' => 'Сообщения',
                'route' => 'dialog',
                'action' => 'list',
                'resource' => 'dialog'
            ),            
            array(
                'label' => 'Баннеры',
                'route' => 'banner',
                'action' => 'index',
                'resource' => 'banner'
            ),
            array(
                'label' => 'Админ-панель',
                'route' => 'admin',
                'action' => 'index',
                'resource' => 'admin'
            ),
            array(
                'label' => 'Сменить пароль',
                'route' => 'change-password',
                'action' => 'index',
                'resource' => 'change-password'
            ),          
        ),
        'footer' => array(
            array(
                'label'  => 'Оферта',
                'route'  => 'page',
                'action' => 'offer',
            ),
            array(
                'label'  => 'Безопасность',
                'route'  => 'page',
                'action' => 'safety',
            ),
            array(
                'label'  => 'Пользовательское соглашение',
                'route'  => 'page',
                'action' => 'agreement',
            ),     
            array(
                'label'  => 'Прейскурант цен',
                'route'  => 'page',
                'action' => 'price',
            ),
            array(
                'label'  => 'Реквизиты',
                'route'  => 'page',
                'action' => 'requisites',
            ),
            array(
                'label'  => 'Баннер-кнопка',
                'route'  => 'page',
                'action' => 'bannerbutton',
            ),
            array(
                'label'  => 'Обратная связь',
                'route'  => 'feedback',
                'action' => 'feedback',
            ),
        )
    ),

    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'FooterNavigation' => 'Application\Navigation\FooterNavigationFactory'
        )
    ),
    'translator' => array(
        'locale' => 'ru_RU',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/403'               => __DIR__ . '/../view/error/403.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
