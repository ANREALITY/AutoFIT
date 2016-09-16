<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointFtgwLinuxUnixFieldset extends AbstractEndpointFieldset implements
    InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('LinuxUnix'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'text',
                'name' => 'username',
                'options' => [
                    'label' => _('application user'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-application-user'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'folder',
                'options' => [
                    'label' => _('folder'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-folder'
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'server_toggle',
                'options' => [
                    'label' => _('server variant'),
                    'value_options' => [
                        [
                            'value' => 'single_server',
                            'label' => _('single server (s. basic settings)'),
                            'selected' => true
                        ],
                        [
                            'value' => 'multiple_servers',
                            'label' => _('multiple servers')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'toggle-server'
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'service_address_toggle',
                'options' => [
                    'label' => _('service address'),
                    'use_hidden_element' => false,
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'toggle-service-address'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'service_address',
                'options' => [
                    'label' => _('IP / server name service address'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-service-address'
                ]
            ]);

        $this->add(
            [
                'name' => 'endpoint_cluster_config',
                'type' => 'Order\Form\Fieldset\EndpointClusterConfig',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'username' => [
                'required' => true
            ],
            'server_toggle' => [
                'required' => false
            ],
            'service_address_toggle' => [
                'required' => false
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_FTGW_LINUX_UNIX;
    }

}
