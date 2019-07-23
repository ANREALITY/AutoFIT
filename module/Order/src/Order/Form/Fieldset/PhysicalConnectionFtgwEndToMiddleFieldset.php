<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Base\DataObject\AbstractPhysicalConnection;
use Base\DataObject\LogicalConnection;

class PhysicalConnectionFtgwEndToMiddleFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName)
    {
        parent::__construct(
            'physical_connection_ftgw_end_to_middle',
            $options,
            $endpointSourceFieldsetServiceName,
            null
        );
    }

    protected function getConcreteRole()
    {
        return AbstractPhysicalConnection::ROLE_END_TO_MIDDLE;
    }

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_FTGW;
    }

}
