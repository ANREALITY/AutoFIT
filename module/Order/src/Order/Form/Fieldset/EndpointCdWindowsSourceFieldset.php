<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\EndpointCdWindows;

class EndpointCdWindowsSourceFieldset extends AbstractEndpointCdWindowsFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - Windows'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'radio',
                'name' => 'transmission_type',
                'options' => [
                    'label' => _('transmission type'),
                    'value_options' => [
                        [
                            'value' => EndpointCdWindows::TRANSMISSION_TYPE_TXT,
                            'label' => EndpointCdWindows::TRANSMISSION_TYPE_TXT,
                            'selected' => true
                        ],
                        [
                            'value' => EndpointCdWindows::TRANSMISSION_TYPE_BIN,
                            'label' => EndpointCdWindows::TRANSMISSION_TYPE_BIN
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
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
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
