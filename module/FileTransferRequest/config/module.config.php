<?php
return array(
    'router' => array(
        'routes' => array(
            'foo' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/file-transfer-request/new',
                    'defaults' => array(
                        'controller' => 'FileTransferRequest\Controller\FileTransferRequest',
                        'action'     => 'new',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'FileTransferRequest\Controller\FileTransferRequest' => 'FileTransferRequest\Controller\FileTransferRequestController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'hydrators' => array(
        'factories' => array(
            'DbSystel\Hydrator\ArticleHydrator' => 'DbSystel\Hydrator\Factory\ArticleHydratorFactory',
            'DbSystel\Hydrator\ProductTypeHydrator' => 'DbSystel\Hydrator\Factory\ProductTypeHydratorFactory',
        ),
    ),
);