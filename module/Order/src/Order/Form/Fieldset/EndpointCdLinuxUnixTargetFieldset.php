<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointCdLinuxUnixTargetFieldset extends AbstractEndpointCdLinuxUnixFieldset
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
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'cluster_toggle',
                'options' => [
                    'label' => _('cluster'),
                    'use_hidden_element' => false,
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\Cluster',
                'name' => 'cluster',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'cluster_toggle' => [
                'required' => false
            ]
        ];
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_TARGET;
    }

}
