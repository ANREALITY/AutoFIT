<?php
use Order\Mvc\Controller\Plugin\Factory\IdentityParamFactory;
use Order\Mvc\Controller\Plugin\IdentityParam;

return [
    'router' => [
        'routes' => [
            'order' => [
                'type' => 'Zend\Router\Http\Segment',
                'options' => [
                    'route' => '/order',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'start' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/start[/:connectionType]',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'start',
                                'connectionType' => ''
                            ]
                        ]
                    ],
                    'create' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/create/:connectionType/:endpointSourceType/:endpointTargetType',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'create',
                                'connectionType' => '',
                                'endpointSourceType' => '',
                                'endpointTargetType' => ''
                            ]
                        ]
                    ],
                    'start-editing' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/start-editing/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'startEditing',
                                'id' => ''
                            ]
                        ]
                    ],
                    'edit' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/edit/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'edit',
                                'id' => ''
                            ]
                        ]
                    ],
                    'submit' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/submit/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'submit',
                                'id' => ''
                            ]
                        ]
                    ],
                    'cancel' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/cancel/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'cancel',
                                'id' => ''
                            ]
                        ]
                    ],
                    'accept' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/accept/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'accept',
                                'id' => ''
                            ]
                        ]
                    ],
                    'decline' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/decline/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'decline',
                                'id' => ''
                            ]
                        ]
                    ],
                    'start-checking' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/start-checking/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'startChecking',
                                'id' => ''
                            ]
                        ]
                    ],
                    'complete' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/complete/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'complete',
                                'id' => ''
                            ]
                        ]
                    ],
                    'show' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/show/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'showOrder',
                                'id' => ''
                            ]
                        ]
                    ],
                    'export' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/export/:id',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'exportOrder',
                                'id' => ''
                            ]
                        ]
                    ],
                    'sync-in-progress' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/sync-in-progress',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'syncInProgress',
                            ]
                        ]
                    ],
                    'operation-denied-for-status' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/process/operation-denied-for-status[/:operation][/:status]',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'operationDeniedForStatus',
                            ]
                        ]
                    ],
                    'list' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/list[/page/:page]',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'listOrders',
                                'page' => 1
                            ]
                        ]
                    ],
                    'list-own' => [
                        'type' => 'Zend\Router\Http\Segment',
                        'options' => [
                            'route' => '/list-own[/page/:page]',
                            'defaults' => [
                                'controller' => 'Order\Controller\Process',
                                'action' => 'listMyOrders',
                                'page' => 1
                            ]
                        ]
                    ],
                    'provide-applications' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-applications',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideApplications'
                            ]
                        ]
                    ],
                    'provide-service-invoice-positions' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-service-invoice-positions',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideServiceInvoicePositions'
                            ]
                        ]
                    ],
                    'provide-service-invoice-positions-basic' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-service-invoice-positions-basic',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideServiceInvoicePositionsBasic'
                            ]
                        ]
                    ],
                    'provide-service-invoice-positions-personal' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-service-invoice-positions-personal',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideServiceInvoicePositionsPersonal'
                            ]
                        ]
                    ],
                    'provide-environments' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-environments',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideEnvironments'
                            ]
                        ]
                    ],
                    'provide-clusters' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-clusters',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideclusters'
                            ]
                        ]
                    ],
                    'provide-servers' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-servers',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideServers'
                            ]
                        ]
                    ],
                    'provide-users' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-users',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideUsers'
                            ]
                        ]
                    ],
                    'provide-file-transfer-requests' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => '/ajax/provide-file-transfer-requests',
                            'defaults' => [
                                'controller' => 'Order\Controller\Ajax',
                                'action' => 'provideFileTransferRequests'
                            ]
                        ]
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
    'controller_plugins' => [
        'factories' => [
            IdentityParam::class => IdentityParamFactory::class,
            'IsInSync' => 'Order\Mvc\Controller\Plugin\Factory\IsInSyncFactory',
            'OrderStatusChecker' => 'Order\Mvc\Controller\Plugin\Factory\OrderStatusCheckerFactory',
        ],
        'aliases' => [
            'IdentityParam' => IdentityParam::class,
        ]
    ],
    'service_manager' => [
        'factories' => [
            // services
            // mappers
            'Order\Mapper\FileTransferRequestMapper' => 'Order\Mapper\Factory\FileTransferRequestMapperFactory',
            'Order\Mapper\ClusterMapper' => 'Order\Mapper\Factory\ClusterMapperFactory',
            // utitlities
            'Order\Utility\ProperServiceNameDetector' => 'Order\Utility\Factory\ProperServiceNameDetectorFactory',
            'Order\Utility\RequestAnalyzer' => 'Order\Utility\Factory\RequestAnalyzerFactory',
            // DataObjects
            'DbSystel\DataObject\FileTransferRequest' => 'Order\DataObject\Factory\FileTransferRequestFactory'
        ],
        'invokables' => [
            // utilities
            'DbSystel\Utility\ArrayProcessor' => 'DbSystel\Utility\ArrayProcessor',
            'DbSystel\DataExport\DataExporter' => 'DbSystel\DataExport\DataExporter'
        ],
        'abstract_factories' => [
            // mappers
            'Order\Mapper\Factory\AbstractMapperFactory',
            // services
            'Order\Service\Factory\AbstractServiceFactory'
        ]
    ],
    'form_elements' => [
        'invokables' => [
            // fieldsets
            'Order\Form\Fieldset\Filter' => 'Order\Form\Fieldset\FilterFieldset',
            'Order\Form\Fieldset\Sort' => 'Order\Form\Fieldset\SortFieldset',
        ],
        'factories' => [
            // forms
            'Order\Form\OrderForm' => 'Order\Form\Factory\OrderFormFactory',
            'Order\Form\OrderSearchForm' => 'Order\Form\Factory\OrderSearchFormFactory',
            // fieldsets
            'Order\Form\Fieldset\Cluster' => 'Order\Form\Fieldset\Factory\ClusterFieldsetFactory',
            'Order\Form\Fieldset\ClusterCreate' => 'Order\Form\Fieldset\Factory\ClusterCreateFieldsetFactory',
            'Order\Form\Fieldset\FileTransferRequestCd' => 'Order\Form\Fieldset\Factory\FileTransferRequestFieldsetFactory',
            'Order\Form\Fieldset\FileTransferRequestFtgw' => 'Order\Form\Fieldset\Factory\FileTransferRequestFieldsetFactory',
            'Order\Form\Fieldset\LogicalConnectionCd' => 'Order\Form\Fieldset\Factory\LogicalConnectionFieldsetFactory',
            'Order\Form\Fieldset\LogicalConnectionFtgw' => 'Order\Form\Fieldset\Factory\LogicalConnectionFieldsetFactory',
            'Order\Form\Fieldset\ServerCommon' => 'Order\Form\Fieldset\Factory\ServerCommonFieldsetFactory',
            'Order\Form\Fieldset\ServerListItem' => 'Order\Form\Fieldset\Factory\ServerListItemFieldsetFactory',
            'Order\Form\Fieldset\User' => 'Order\Form\Fieldset\Factory\UserFieldsetFactory',

            'Order\Form\Fieldset\ProtocolSetForProtocolServerSource' => 'Order\Form\Fieldset\Factory\ProtocolSetFieldsetFactory',
            'Order\Form\Fieldset\ProtocolSetForProtocolServerTarget' => 'Order\Form\Fieldset\Factory\ProtocolSetFieldsetFactory',
            'Order\Form\Fieldset\ProtocolSetForSelfService' => 'Order\Form\Fieldset\Factory\ProtocolSetFieldsetFactory',

        ],
        'abstract_factories' => [
            // fieldsets
            'Order\Form\Fieldset\Factory\AbstractCommonFieldsetFactory',
            'Order\Form\Fieldset\Factory\AbstractEndpointFieldsetFactory',
            'Order\Form\Fieldset\Factory\AbstractPhysicalConnectionFieldsetFactory',
            'Order\Form\Fieldset\Factory\AbstractServiceInvoicePositionFieldsetFactory'
        ],
        'shared' => [
            'Order\Form\Fieldset\AccessConfig' => false,
            'Order\Form\Fieldset\AccessConfigSet' => false,
            'Order\Form\Fieldset\Application' => false,
            'Order\Form\Fieldset\Cluster' => false,
            'Order\Form\Fieldset\Customer' => false,
            'Order\Form\Fieldset\EndpointCdAs400Source' => false,
            'Order\Form\Fieldset\EndpointCdAs400Target' => false,
            'Order\Form\Fieldset\EndpointCdLinuxUnixSource' => false,
            'Order\Form\Fieldset\EndpointCdLinuxUnixTarget' => false,
            'Order\Form\Fieldset\EndpointCdTandemSource' => false,
            'Order\Form\Fieldset\EndpointCdTandemTarget' => false,
            'Order\Form\Fieldset\EndpointCdWindowsSource' => false,
            'Order\Form\Fieldset\EndpointCdWindowsTarget' => false,
            'Order\Form\Fieldset\EndpointCdWindowsShareSource' => false,
            'Order\Form\Fieldset\EndpointCdWindowsShareTarget' => false,
            'Order\Form\Fieldset\EndpointCdZosSource' => false,
            'Order\Form\Fieldset\EndpointCdZosTarget' => false,
            'Order\Form\Fieldset\EndpointCdWindowsSource' => false,
            'Order\Form\Fieldset\EndpointCdWindowsTarget' => false,
            'Order\Form\Fieldset\EndpointClusterConfig' => false,
            'Order\Form\Fieldset\EndpointFtgwProtocolServerSource' => false,
            'Order\Form\Fieldset\EndpointFtgwProtocolServerTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwSelfServiceSource' => false,
            'Order\Form\Fieldset\EndpointFtgwSelfServiceTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwWindowsSource' => false,
            'Order\Form\Fieldset\EndpointFtgwWindowsTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwWindowsShareSource' => false,
            'Order\Form\Fieldset\EndpointFtgwWindowsShareTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwLinuxUnixSource' => false,
            'Order\Form\Fieldset\EndpointFtgwLinuxUnixTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwCdZosSource' => false,
            'Order\Form\Fieldset\EndpointFtgwCdZosTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwCdTandemSource' => false,
            'Order\Form\Fieldset\EndpointFtgwCdTandemTarget' => false,
            'Order\Form\Fieldset\EndpointFtgwCdAs400Source' => false,
            'Order\Form\Fieldset\EndpointFtgwCdAs400Target' => false,
            'Order\Form\Fieldset\EndpointServerConfig' => false,
            'Order\Form\Fieldset\Environment' => false,
            'Order\Form\Fieldset\ExternalServer' => false,
            'Order\Form\Fieldset\FileTransferRequestCd' => false,
            'Order\Form\Fieldset\FileTransferRequestFtgw' => false,
            'Order\Form\Fieldset\IncludeParameter' => false,
            'Order\Form\Fieldset\IncludeParameterSet' => false,
            'Order\Form\Fieldset\ProtocolSetForSelfService' => false,
            'Order\Form\Fieldset\ProtocolSetForProtocolServerSource' => false,
            'Order\Form\Fieldset\ProtocolSetForProtocolServerTarget' => false,
            'Order\Form\Fieldset\LogicalConnectionCd' => false,
            'Order\Form\Fieldset\LogicalConnectionFtgw' => false,
            'Order\Form\Fieldset\Notification' => false,
            'Order\Form\Fieldset\PhysicalConnectionCdEndToEnd' => false,
            'Order\Form\Fieldset\PhysicalConnectionFtgwEndToMiddle' => false,
            'Order\Form\Fieldset\PhysicalConnectionFtgwMiddleToEnd' => false,
            'Order\Form\Fieldset\ServerCommon' => false,
            'Order\Form\Fieldset\ServerListItem' => false,
            'Order\Form\Fieldset\ServiceInvoicePositionBasic' => false,
            'Order\Form\Fieldset\ServiceInvoicePositionPersonal' => false,
            'Order\Form\Fieldset\User' => false,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ],
        'template_map' => [
            'pagination' => __DIR__ . '/../view/partials/pagination.phtml',
        ]
    ],
    'view_helpers' => [
        'invokables' => [
            'formelementerrors' => 'DbSystel\Form\View\Helper\FormElementErrors',
            'orderTypeDetector' => 'Order\View\Helper\OrderTypeDetector',
        ],
        'factories' => [
            'OrderStatusChecker' => 'Order\View\Helper\Factory\OrderStatusCheckerFactory',
        ]
    ],
    'hydrators' => [
        'factories' => [
            'DbSystel\Hydrator\ProtocolSetHydrator' => 'DbSystel\Hydrator\Factory\ProtocolSetHydratorFactory',
            'DbSystel\Hydrator\ProtocolHydrator' => 'DbSystel\Hydrator\Factory\ProtocolHydratorFactory'
        ]
    ]
];
