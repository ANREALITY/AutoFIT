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
            'list-orders' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/list-orders',
                    'defaults' => [
                        'controller' => 'Order\Controller\Process',
                        'action' => 'listOrders'
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

            'Order\Mapper\CustomerMapper' => 'Order\Mapper\Factory\CustomerMapperFactory',
            'Order\Mapper\EndpointCdAs400Mapper' => 'Order\Mapper\Factory\EndpointCdAs400MapperFactory',
            'Order\Mapper\PhysicalConnectionCdMapper' => 'Order\Mapper\Factory\PhysicalConnectionCdMapperFactory',
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
        'factories' => []
    ]
];