<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

return array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                ),
                
            )
        ),
        'configuration' => array(
            'orm_default' => array(
                'filters' => array(
                    'soft-deleteable' => 'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
                )
            )
        ),
        'eventmanager' => array(
            'orm_default' => array(
                'subscribers' => array(
                    'Gedmo\SoftDeleteable\SoftDeleteableListener'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        //'action'     => 'index', // @TODO cos tu nie dziala
                    ),
                    
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/product[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Product',
                            ),
                        ),
                    ),
                    'item' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/item[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Item',
                            ),
                        ),
                    ),
                    'tag' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/tag[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Application\Controller\Tag',
                            ),
                        ),
                    ),
                )
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'Model\Importer' => function($serviceManager) {
                $oModel = new \Application\Model\Importer();
                $oModel->setEntityManager($serviceManager->get('Doctrine\ORM\EntityManager'));
                
                return $oModel;
            },
            'Model\Product' => function($serviceManager) {
                $oModel = new \Application\Model\Product();
                $oModel->setEntityManager($serviceManager->get('Doctrine\ORM\EntityManager'));
                
                return $oModel;
            },
            'Model\Item' => function($serviceManager) {
                $oModel = new \Application\Model\Item();
                $oModel->setEntityManager($serviceManager->get('Doctrine\ORM\EntityManager'));
                
                return $oModel;
            },
            'Model\Tag' => function($serviceManager) {
                $oModel = new \Application\Model\Tag();
                $oModel->setEntityManager($serviceManager->get('Doctrine\ORM\EntityManager'));
                
                return $oModel;
            }
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
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
            'Application\Controller\Index' => Controller\IndexController::class,
            'Application\Controller\Product' => Controller\ProductController::class,
            'Application\Controller\Item' => Controller\ItemController::class,
            'Application\Controller\Tag' => Controller\TagController::class
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
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
