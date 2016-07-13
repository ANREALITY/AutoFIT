<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointCdLinuxUnixFieldset extends AbstractEndpointFieldset implements
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
                    'class' => 'form-control'
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
                    'required' => 'required',
                    'class' => 'form-control'
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
                'name' => 'servers',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('multiple servers'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\Server'
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12 fieldset-multiple-servers'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_server',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default',
                    'id' => 'add-endpoint-' . $this->getConcreteRole() . '-server-button',
                    'value' => _('add a server')
                ]
            ]);

        $this->add(
            [
                'name' => 'external_servers',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('multiple external servers'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\ExternalServer'
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12 fieldset-multiple-external-servers'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_external_server',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default',
                    'id' => 'add-endpoint-' . $this->getConcreteRole() . '-external-server-button',
                    'value' => _('add an external server')
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
        return AbstractEndpoint::TYPE_CD_LINUX_UNIX;
    }

}
