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
            'FileTransferRequest\Controller\Edit' => 'FileTransferRequest\Controller\Factory\EditControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            // mappers
            'FileTransferRequest\Mapper\CustomerMapperInterface' => 'FileTransferRequest\Mapper\Factory\CustomerMapperFactory',
            'FileTransferRequest\Mapper\EndpointCdAs400MapperInterface' => 'FileTransferRequest\Mapper\Factory\EndpointCdAs400MapperFactory',
            'FileTransferRequest\Mapper\EndpointCdTandemMapperInterface' => 'FileTransferRequest\Mapper\Factory\EndpointCdTandemMapperFactory',
            'FileTransferRequest\Mapper\EndpointMapperInterface' => 'FileTransferRequest\Mapper\Factory\EndpointMapperFactory',
            'FileTransferRequest\Mapper\FileTransferRequestMapperInterface' => 'FileTransferRequest\Mapper\Factory\FileTransferRequestMapperFactory',
            'FileTransferRequest\Mapper\LogicalConnectionMapperInterface' => 'FileTransferRequest\Mapper\Factory\LogicalConnectionMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionCdMapperInterface' => 'FileTransferRequest\Mapper\Factory\PhysicalConnectionCdMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionFtgwMapperInterface' => 'FileTransferRequest\Mapper\Factory\PhysicalConnectionFtgwMapperFactory',
            'FileTransferRequest\Mapper\PhysicalConnectionMapperInterface' => 'FileTransferRequest\Mapper\Factory\PhysicalConnectionMapperFactory',
            'FileTransferRequest\Mapper\UserMapperInterface' => 'FileTransferRequest\Mapper\Factory\UserMapperFactory',
            // services
            'FileTransferRequest\Service\FileTransferRequestService' => 'FileTransferRequest\Service\Factory\FileTransferRequestServiceFactory',
            // forms
            'FileTransferRequest\Form\FileTransferRequestForm' => 'FileTransferRequest\Form\Factory\FileTransferRequestFormFactory',
            // fieldsets
            'FileTransferRequest\Form\Fieldset\BillingFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\BillingFieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdAs400Fieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdAs400FieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdAs400SourceFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdAs400SourceFieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdAs400TargetFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdAs400TargetFieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdTandemFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdTandemFieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdTandemSourceFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdTandemSourceFieldsetFactory',
            'FileTransferRequest\Form\FieldsetEndpointCdTandemTargetFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdTandemTargetFieldsetFactory',
            'FileTransferRequest\Form\Fieldset\EndpointCdFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdFieldsetFactory',
            'FileTransferRequest\Form\Fieldset\EndpointCdSourceFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdSourceFieldsetFactory',
            'FileTransferRequest\Form\Fieldset\EndpointCdTargetFieldset' => 'FileTransferRequest\Form\Fieldset\Factory\EndpointCdTargetFieldsetFactory',
            // adapters
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