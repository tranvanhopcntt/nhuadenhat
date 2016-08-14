<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Home',
                        'action'     => 'index',
                    ),
                ),

                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Home' => 'Application\Controller\HomeController',
            'Application\Controller\Introduction' => 'Application\Controller\IntroductionController',
            'Application\Controller\Network' => 'Application\Controller\NetworkController',
            'Application\Controller\News' => 'Application\Controller\NewsController',
            'Application\Controller\Project' => 'Application\Controller\ProjectController',
            'Application\Controller\Product' => 'Application\Controller\ProductController',
            'Application\Controller\Quotes' => 'Application\Controller\QuotesController',
            'Application\Controller\Contact' => 'Application\Controller\ContactController',
            'Application\Controller\Sitemap' => 'Application\Controller\SitemapController',
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'Soap\Controller\SoapController' => 'SomeFactoryYouWillNeedToWrite',
        ),
    ),
    'translator' => array(
        'locale' => 'vi_VN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/application' => __DIR__ . '/../view/layout/application.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'module_layouts' => array(
        'Application' => 'layout/application',
    ),

    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
