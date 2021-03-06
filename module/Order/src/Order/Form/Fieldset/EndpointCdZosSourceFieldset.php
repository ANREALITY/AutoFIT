<?php
namespace Order\Form\Fieldset;

use Base\DataObject\AbstractEndpoint;

class EndpointCdZosSourceFieldset extends AbstractEndpointCdZosFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - Zos'));
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
        return AbstractEndpoint::ROLE_SOURCE;
    }

}
