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
            'Order\Form\OrderForm' => 'Order\Form\Factory\OrderFormFactory',
            // data preparators
            // fieldsets
            'Order\Form\Fieldset\FileTransferRequestFieldset' => 'Order\Form\Fieldset\Factory\FileTransferRequestFieldsetFactory',
            'Order\Form\Fieldset\LogicalConnectionFieldset' => 'Order\Form\Fieldset\Factory\LogicalConnectionFieldsetFactory',
            'Order\Form\Fieldset\ServiceInvoicePositionBasicFieldset' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionBasicFieldsetFactory',
            'Order\Form\Fieldset\ServiceInvoicePositionPersonalFieldset' => 'Order\Form\Fieldset\Factory\ServiceInvoicePositionPersonalFieldsetFactory',
            'Order\Form\Fieldset\UserFieldset' => 'Order\Form\Fieldset\Factory\UserFieldsetFactory',
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