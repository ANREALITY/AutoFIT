<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;

class EndpointFtgwCdLinuxUnixTargetFieldset extends AbstractEndpointFtgwCdLinuxUnixFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - LinuxUnix'));
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
                    'class' => 'form-control field-folder'
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
                            'value' => EndpointFtgwLinuxUnix::TRANSMISSION_TYPE_TXT,
                            'label' => EndpointFtgwLinuxUnix::TRANSMISSION_TYPE_TXT,
                            'selected' => true
                        ],
                        [
                            'value' => EndpointFtgwLinuxUnix::TRANSMISSION_TYPE_BIN,
                            'label' => EndpointFtgwLinuxUnix::TRANSMISSION_TYPE_BIN
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12 '
                    ]
                ],
                'attributes' => [
                    'class' => 'field-transmission-type'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_TARGET;
    }

}
