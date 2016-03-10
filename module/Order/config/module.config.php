<?php
return array(
    'router' => array(
        'routes' => array(
            'create-order' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/order/process/create',
                    'defaults' => array(
                        'controller' => 'Order\Controller\Process',
                        'action'     => 'create',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Order\Controller\Process' => 'Order\Controller\Factory\ProcessControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            // mappers
            // services
            // forms
            // data preparators
            // fieldsets
            // adapters
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'invokables' => array(
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'hydrators' => array(
        'factories' => array(
        ),
    ),
);