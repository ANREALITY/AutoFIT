<?php
namespace Order\Form\Fieldset;

use Base\DataObject\AbstractEndpoint;

class EndpointFtgwSelfServiceTargetFieldset extends AbstractEndpointFtgwSelfServiceFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - Self-Service'));
    }

    public function init()
    {
        parent::init();
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
