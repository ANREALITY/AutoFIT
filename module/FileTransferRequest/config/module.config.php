<?php
return array(
    'router' => array(
        'routes' => array(
            'new-request' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/file-transfer-request/new',
                    'defaults' => array(
                        'controller' => 'FileTransferRequest\Controller\Edit',
                        'action'     => 'new',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'FileTransferRequest\Controller\Edit' => 'FileTransferRequest\Factory\EditControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'FileTransferRequest\Mapper\FileTransferRequestMapperInterface'   => 'FileTransferRequest\Factory\FileTransferRequestMapperFactory',
            'FileTransferRequest\Service\FileTransferRequestService' => 'FileTransferRequest\Factory\FileTransferRequestServiceFactory',
            'Zend\Db\Adapter\Adapter'           => 'Zend\Db\Adapter\AdapterServiceFactory',
            'FileTransferRequest\Form\FileTransferRequestForm' => 'FileTransferRequest\Factory\FileTransferRequestFormFactory',
            'FileTransferRequest\Form\BillingFieldset' => 'FileTransferRequest\Factory\BillingFieldsetFactory',
            'FileTransferRequest\Form\SourceFieldset' => 'FileTransferRequest\Factory\SourceFieldsetFactory',
            'FileTransferRequest\Form\TargetFieldset' => 'FileTransferRequest\Factory\TargetFieldsetFactory',
        )
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