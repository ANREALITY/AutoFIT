<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointFtgwProtocolServerFieldset extends AbstractEndpointFieldset implements
    InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('ProtocolServer'));
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
                'name' => 'address_toggle',
                'options' => [
                    'label' => _('address type'),
                    'value_options' => [
                        [
                            'value' => 'dns_address',
                            'label' => _('DNS address'),
                            'selected' => true
                        ],
                        [
                            'value' => 'ip',
                            'label' => _('IP')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'toggle-address'
                ]
            ]);

        $this->add([
            'name' => 'dns_address',
            'type' => 'text',
            'options' => [
                'label' => _('DNS address'),
                'label_attributes' => [
                    'class' => 'col-md-12 required-conditionally'
                ]
            ],
            'attributes' => [
                'class' => 'form-control field-dns-address'
            ]
        ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'ip',
                'options' => [
                    'label' => _('IP'),
                    'label_attributes' => [
                        'class' => 'col-md-12 required-conditionally'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-ip'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'port',
                'options' => [
                    'label' => _('port'),
                    'label_attributes' => [
                        'class' => 'col-md-12 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-port'
                ]
            ]);

        $this->add(
            [
                'name' => 'protocol_set',
                'type' => 'Order\Form\Fieldset\ProtocolSetForProtocolServer',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'server_toggle' => [
                'required' => false
            ],
            'dns_address' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/',
                            'message' => _('The input does not match against the DNS pattern')
                        ]
                    ],
                ]
            ],
            'ip' => [
                'required' => false,
                'validators' => [
                    [
                        'name' => 'Ip'
                    ]
                ]
            ],
            'port' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Digits'
                    ],
                    [
                        'name' => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 65535
                        ]
                    ]
                ]
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_FTGW_PROTOCOL_SERVER;
    }

}
