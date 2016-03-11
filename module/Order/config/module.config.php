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
            ]
        ]
    ],
    'controllers' => [
        'invokables' => [],
        'factories' => [
            'Order\Controller\Process' => 'Order\Controller\Factory\ProcessControllerFactory'
        ]
    ],
    'service_manager' => [
        'factories' => [
            // mappers
            // services
            // forms
            'Order\Form\OrderForm' => 'Order\Form\Factory\OrderFormFactory',
            // data preparators
            // adapters
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ],
        'invokables' => []
    ],
    'form_elements' => [
        'factories' => []
        // fieldsets
        // This isn't working (yet).
        /*
         * 'Order\Form\Fieldset\FileTransferRequest' => 'Order\Form\Fieldset\Factory\FileTransferRequestFieldsetFactory',
         * 'Order\Form\Fieldset\LogicalConnection' => 'Order\Form\Fieldset\Factory\LogicalConnectionFieldsetFactory',
         * 'Order\Form\Fieldset\ServiceInvoicePositionBasic' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionBasicFieldsetFactory',
         * 'Order\Form\Fieldset\ServiceInvoicePositionPersonal' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionPersonalFieldsetFactory',
         * 'Order\Form\Fieldset\User' => 'Order\Form\Fieldset\Factory\UserFieldsetFactory',
         */
        
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],
    'hydrators' => [
        'factories' => []
    ]
];