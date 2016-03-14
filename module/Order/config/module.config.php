<?php
return [
    'router' => [
        'routes' => [
            'create-order' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/process/create',
                    'defaults' => [
                        'controller' => 'Order\Controller\Process',
                        'action' => 'create'
                    ]
                ]
            ],
            'provide-applications' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-applications',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideApplications'
                    ]
                ]
            ],
            'provide-environments' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-environments',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideEnvironments'
                    ]
                ]
            ],
            'provide-servers' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-servers',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideServers'
                    ]
                ]
            ],
            'provide-service-invoice-positions' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/order/ajax/provide-service-invoice-positions',
                    'defaults' => [
                        'controller' => 'Order\Controller\Ajax',
                        'action' => 'provideServiceInvoicePositions'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'invokables' => [],
        'factories' => [
            'Order\Controller\Process' => 'Order\Controller\Factory\ProcessControllerFactory',
            'Order\Controller\Ajax' => 'Order\Controller\Factory\AjaxControllerFactory'
        ]
    ],
    'service_manager' => [
        'factories' => [
            // services
            'Order\Service\ApplicationService' => 'Order\Service\Factory\ApplicationServiceFactory',
            'Order\Service\EnvironmentService' => 'Order\Service\Factory\EnvironmentServiceFactory',
            'Order\Service\FileTransferRequestService' => 'Order\Service\Factory\FileTransferRequestServiceFactory',
            'Order\Service\ServerService' => 'Order\Service\Factory\ServerServiceFactory',
            'Order\Service\ServiceInvoicePositionService' => 'Order\Service\Factory\ServiceInvoicePositionServiceFactory',
            // mappers
            'Order\Mapper\ApplicationMapper' => 'Order\Mapper\Factory\ApplicationMapperFactory',
            'Order\Mapper\EnvironmentMapper' => 'Order\Mapper\Factory\EnvironmentMapperFactory',
            'Order\Mapper\FileTransferRequestMapper' => 'Order\Mapper\Factory\FileTransferRequestMapperFactory',
            'Order\Mapper\LogicalConnectionMapper' => 'Order\Mapper\Factory\LogicalConnectionMapperFactory',
            'Order\Mapper\ServerMapper' => 'Order\Mapper\Factory\ServerMapperFactory',
            'Order\Mapper\ServiceInvoicePositionMapper' => 'Order\Mapper\Factory\ServiceInvoicePositionMapperFactory',
            'Order\Mapper\UserMapper' => 'Order\Mapper\Factory\UserMapperFactory',
            // data preparators
            // adapters
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ],
        'invokables' => []
    ],
    'form_elements' => [
        'factories' => [
            // forms
            'Order\Form\OrderForm' => 'Order\Form\Factory\OrderFormFactory',
            // fieldsets
            'Order\Form\Fieldset\Application' => 'Order\Form\Fieldset\Factory\ApplicationFieldsetFactory',
            'Order\Form\Fieldset\Customer' => 'Order\Form\Fieldset\Factory\CustomerFieldsetFactory',
            'Order\Form\Fieldset\EndpointCdAs400' => 'Order\Form\Fieldset\Factory\EndpointCdAs400FieldsetFactory',
            'Order\Form\Fieldset\EndpointCdAs400Source' => 'Order\Form\Fieldset\Factory\EndpointCdAs400SourceFieldsetFactory',
            'Order\Form\Fieldset\EndpointCdAs400Target' => 'Order\Form\Fieldset\Factory\EndpointCdAs400TargetFieldsetFactory',
            'Order\Form\Fieldset\EndpointCd' => 'Order\Form\Fieldset\Factory\EndpointCdFieldsetFactory',
            'Order\Form\Fieldset\EndpointCdSource' => 'Order\Form\Fieldset\Factory\EndpointCdSourceFieldsetFactory',
            'Order\Form\Fieldset\EndpointCdTarget' => 'Order\Form\Fieldset\Factory\EndpointCdTargetFieldsetFactory',
            'Order\Form\Fieldset\FileTransferRequest' => 'Order\Form\Fieldset\Factory\FileTransferRequestFieldsetFactory',
            'Order\Form\Fieldset\LogicalConnection' => 'Order\Form\Fieldset\Factory\LogicalConnectionFieldsetFactory',
            'Order\Form\Fieldset\PhysicalConnectionCd' => 'Order\Form\Fieldset\Factory\PhysicalConnectionCdFieldsetFactory',
            'Order\Form\Fieldset\PhysicalConnectionFtgw' => 'Order\Form\Fieldset\Factory\PhysicalConnectionFtgwFieldsetFactory',
            'Order\Form\Fieldset\Server' => 'Order\Form\Fieldset\Factory\ServerFieldsetFactory',
            'Order\Form\Fieldset\ServiceInvoicePositionBasic' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionBasicFieldsetFactory',
            'Order\Form\Fieldset\ServiceInvoicePositionPersonal' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionPersonalFieldsetFactory',
            'Order\Form\Fieldset\User' => 'Order\Form\Fieldset\Factory\UserFieldsetFactory'
        ],
        'shared' => [
            'Order\Form\Fieldset\Application' => false,
            'Order\Form\Fieldset\Customer' => false,
            'Order\Form\Fieldset\EndpointCdAs400' => false,
            'Order\Form\Fieldset\EndpointCdAs400Source' => false,
            'Order\Form\Fieldset\EndpointCdAs400Target' => false,
            'Order\Form\Fieldset\EndpointCd' => false,
            'Order\Form\Fieldset\EndpointCdSource' => false,
            'Order\Form\Fieldset\EndpointCdTarget' => false,
            'Order\Form\Fieldset\FileTransferRequest' => false,
            'Order\Form\Fieldset\LogicalConnection' => false,
            'Order\Form\Fieldset\PhysicalConnectionCd' => false,
            'Order\Form\Fieldset\PhysicalConnectionFtgw' => false,
            'Order\Form\Fieldset\Server' => false,
            'Order\Form\Fieldset\ServiceInvoicePositionBasic' => false,
            'Order\Form\Fieldset\ServiceInvoicePositionPersonal' => false,
            'Order\Form\Fieldset\User' => false
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
    'hydrators' => [
        'factories' => [
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
            'DbSystel\Hydrator\UserHydrator' => 'DbSystel\Hydrator\Factory\UserHydratorFactory'
        ]
    ]
];