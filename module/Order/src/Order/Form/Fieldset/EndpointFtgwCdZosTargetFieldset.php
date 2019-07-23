<?php
namespace Order\Form\Fieldset;

use Base\DataObject\AbstractEndpoint;

class EndpointFtgwCdZosTargetFieldset extends AbstractEndpointFtgwCdZosFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - Zos'));
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
