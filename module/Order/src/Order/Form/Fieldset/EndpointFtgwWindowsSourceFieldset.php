<?php
namespace Order\Form\Fieldset;

use Base\DataObject\AbstractEndpoint;

class EndpointFtgwWindowsSourceFieldset extends AbstractEndpointFtgwWindowsFieldset
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
                'name' => 'include_parameter_set',
                'type' => 'Order\Form\Fieldset\IncludeParameterSet',
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
        return AbstractEndpoint::ROLE_SOURCE;
    }

}
