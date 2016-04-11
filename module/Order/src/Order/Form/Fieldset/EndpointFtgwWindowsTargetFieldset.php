<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointFtgwWindowsTargetFieldset extends AbstractEndpointFtgwWindowsFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - Windows'));
    }

    public function init()
    {
        parent::init();
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_TARGET;
    }

}
