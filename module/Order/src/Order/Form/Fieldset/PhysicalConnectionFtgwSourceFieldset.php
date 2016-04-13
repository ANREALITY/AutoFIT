<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\LogicalConnection;

class PhysicalConnectionFtgwSourceFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName)
    {
        parent::__construct('physical_connection_ftgw_source', $options, $endpointSourceFieldsetServiceName, null);
    }

    protected function getConcreteRole()
    {
        return AbstractPhysicalConnection::ROLE_SOURCE;
    }

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_FTGW;
    }

}
