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
            'DbSystel\Hydrator\ApplicationHydrator' => 'DbSystel\Hydrator\Factory\ApplicationHydratorFactory',
            'DbSystel\Hydrator\ArticleHydrator' => 'DbSystel\Hydrator\Factory\ArticleHydratorFactory',
            'DbSystel\Hydrator\EndpointCdAs400Hydrator' => 'DbSystel\Hydrator\Factory\EndpointCdAs400HydratorFactory',
            'DbSystel\Hydrator\EndpointCdTandemHydrator' => 'DbSystel\Hydrator\Factory\EndpointCdTandemHydratorFactory',
            'DbSystel\Hydrator\EnvironmentHydrator' => 'DbSystel\Hydrator\Factory\EnvironmentHydratorFactory',
            'DbSystel\Hydrator\FileTransferRequestHydrator' => 'DbSystel\Hydrator\Factory\FileTransferRequestHydratorFactory',
            'DbSystel\Hydrator\PhysicalConnectionCdHydrator' => 'DbSystel\Hydrator\Factory\PhysicalConnectionCdHydratorFactory',
            'DbSystel\Hydrator\PhysicalConnectionFtgwHydrator' => 'DbSystel\Hydrator\Factory\PhysicalConnectionFtgwHydratorFactory',
            'DbSystel\Hydrator\ProductTypeHydrator' => 'DbSystel\Hydrator\Factory\ProductTypeHydratorFactory',
            'DbSystel\Hydrator\ServerHydrator' => 'DbSystel\Hydrator\Factory\ServerHydratorFactory',
            'DbSystel\Hydrator\ServiceInvoiceHydrator' => 'DbSystel\Hydrator\Factory\ServiceInvoiceHydratorFactory',
            'DbSystel\Hydrator\ServiceInvoicePositionHydrator' => 'DbSystel\Hydrator\Factory\ServiceInvoicePositionHydratorFactory',
            'DbSystel\Hydrator\UserHydrator' => 'DbSystel\Hydrator\Factory\UserHydratorFactory',
        ),
    ),
);