<?php
return array(
    'router' => array(
        'routes' => array(
            'create-request' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/file-transfer-request/create-request',
                    'defaults' => array(
                        'controller' => 'FileTransferRequest\Controller\Edit',
                        'action'     => 'createRequest',
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
            // mappers
            'FileTransferRequest\Mapper\CustomerMapperInterface' => 'FileTransferRequest\Factory\CustomerMapperFactory',
            'FileTransferRequest\Mapper\EndpointCdAs400MapperInterface' => 'FileTransferRequest\Factory\EndpointCdAs400MapperFactory',
            'FileTransferRequest\Mapper\EndpointCdTandemMapperInterface' => 'FileTransferRequest\Factory\EndpointCdTandemMapperFactory',
            'FileTransferRequest\Mapper\EndpointMapperInterface' => 'FileTransferRequest\Factory\EndpointMapperFactory',
            'FileTransferRequest\Mapper\FileTransferRequestMapperInterface' => 'FileTransferRequest\Factory\FileTransferRequestMapperFactory',
            'FileTransferRequest\Mapper\LogicalConnectionMapperInterface' => 'FileTransferRequest\Factory\LogicalConnectionMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionCdMapperInterface' => 'FileTransferRequest\Factory\PhysicalConnectionCdMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionFtgwMapperInterface' => 'FileTransferRequest\Factory\PhysicalConnectionFtgwMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionMapperInterface' => 'FileTransferRequest\Factory\PhysicalConnectionMapperFactory',
            'FileTransferRequest\Mapper\UserMapperInterface' => 'FileTransferRequest\Factory\UserMapperFactory',
            // services
            'FileTransferRequest\Service\FileTransferRequestService' => 'FileTransferRequest\Factory\FileTransferRequestServiceFactory',
            // forms
            'FileTransferRequest\Form\FileTransferRequestForm' => 'FileTransferRequest\Factory\FileTransferRequestFormFactory',
            // fieldsets
            'FileTransferRequest\Form\BillingFieldset' => 'FileTransferRequest\Factory\BillingFieldsetFactory',
            'FileTransferRequest\Form\SourceFieldset' => 'FileTransferRequest\Factory\SourceFieldsetFactory',
            'FileTransferRequest\Form\TargetFieldset' => 'FileTransferRequest\Factory\TargetFieldsetFactory',
            // Zend
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
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
            'DbSystel\Hydrator\CustomerHydrator' => 'DbSystel\Hydrator\Factory\CustomerHydratorFactory',
            'DbSystel\Hydrator\EndpointCdAs400Hydrator' => 'DbSystel\Hydrator\Factory\EndpointCdAs400HydratorFactory',
            'DbSystel\Hydrator\EndpointCdHydrator' => 'DbSystel\Hydrator\Factory\EndpointCdHydratorFactory',
            'DbSystel\Hydrator\EndpointCdTandemHydrator' => 'DbSystel\Hydrator\Factory\EndpointCdTandemHydratorFactory',
            'DbSystel\Hydrator\EndpointFtgwHydrator' => 'DbSystel\Hydrator\Factory\EndpointFtgwHydratorFactory',
            'DbSystel\Hydrator\EnvironmentHydrator' => 'DbSystel\Hydrator\Factory\EnvironmentHydratorFactory',
            'DbSystel\Hydrator\FileTransferRequestHydrator' => 'DbSystel\Hydrator\Factory\FileTransferRequestHydratorFactory',
            'DbSystel\Hydrator\LogicalConnectionHydrator' => 'DbSystel\Hydrator\Factory\LogicalConnectionHydratorFactory',
            'DbSystel\Hydrator\PhysicalConnectionCdHydrator' => 'DbSystel\Hydrator\Factory\PhysicalConnectionCdHydratorFactory',
            'DbSystel\Hydrator\PhysicalConnectionFtgwHydrator' => 'DbSystel\Hydrator\Factory\PhysicalConnectionFtgwHydratorFactory',
            'DbSystel\Hydrator\PhysicalConnectionHydrator' => 'DbSystel\Hydrator\Factory\PhysicalConnectionHydratorFactory',
            'DbSystel\Hydrator\ProductTypeHydrator' => 'DbSystel\Hydrator\Factory\ProductTypeHydratorFactory',
            'DbSystel\Hydrator\ServerHydrator' => 'DbSystel\Hydrator\Factory\ServerHydratorFactory',
            'DbSystel\Hydrator\ServiceInvoiceHydrator' => 'DbSystel\Hydrator\Factory\ServiceInvoiceHydratorFactory',
            'DbSystel\Hydrator\ServiceInvoicePositionHydrator' => 'DbSystel\Hydrator\Factory\ServiceInvoicePositionHydratorFactory',
            'DbSystel\Hydrator\UserHydrator' => 'DbSystel\Hydrator\Factory\UserHydratorFactory',
        ),
    ),
);