<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Base\DataObject\AbstractPhysicalConnection;
use Base\DataObject\LogicalConnection;

class PhysicalConnectionCdEndToEndFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName,
        string $endpointTargetFieldsetServiceName)
    {
        parent::__construct('physical_connection_cd_end_to_end', $options, $endpointSourceFieldsetServiceName,
            $endpointTargetFieldsetServiceName);
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
        return AbstractPhysicalConnection::ROLE_END_TO_END;
    }

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_CD;
    }

}
