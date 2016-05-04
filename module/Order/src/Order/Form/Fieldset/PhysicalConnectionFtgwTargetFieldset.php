<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\LogicalConnection;

class PhysicalConnectionFtgwTargetFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointTargetFieldsetServiceName)
    {
        parent::__construct('physical_connection_ftgw_target', $options, null, $endpointTargetFieldsetServiceName);
    }

    protected function getConcreteRole()
    {
        return AbstractPhysicalConnection::ROLE_TARGET;
    }

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_FTGW;
    }

}
