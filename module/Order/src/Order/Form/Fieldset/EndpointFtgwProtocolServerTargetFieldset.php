<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointFtgwProtocolServerTargetFieldset extends AbstractEndpointFtgwProtocolServerFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - ProtocolServer'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'name' => 'file_parameter_set',
                'type' => 'Order\Form\Fieldset\FileParameterSet',
                'options' => []
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
