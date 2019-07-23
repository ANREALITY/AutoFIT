<?php
namespace Order\Form\Fieldset;

use Base\DataObject\AbstractEndpoint;
use Base\DataObject\EndpointFtgwProtocolServer;

class EndpointFtgwProtocolServerSourceFieldset extends AbstractEndpointFtgwProtocolServerFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - ProtocolServer'));
    }

    public function init()
    {
        parent::init();

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
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'transmission_type',
                'options' => [
                    'label' => _('transmission type'),
                    'value_options' => [
                        [
                            'value' => EndpointFtgwProtocolServer::TRANSMISSION_TYPE_TXT,
                            'label' => EndpointFtgwProtocolServer::TRANSMISSION_TYPE_TXT,
                            'selected' => true
                        ],
                        [
                            'value' => EndpointFtgwProtocolServer::TRANSMISSION_TYPE_BIN,
                            'label' => EndpointFtgwProtocolServer::TRANSMISSION_TYPE_BIN
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'field-transmission-type'
                ]
            ]);

        $this->add(
            [
                'name' => 'include_parameter_set',
                'type' => 'Order\Form\Fieldset\IncludeParameterSet',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'protocol_set',
                'type' => 'Order\Form\Fieldset\ProtocolSetForProtocolServerSource',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'folder' => [
                'required' => false
            ],
            'transmission_type' => [
                'required' => true
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_SOURCE;
    }

}
