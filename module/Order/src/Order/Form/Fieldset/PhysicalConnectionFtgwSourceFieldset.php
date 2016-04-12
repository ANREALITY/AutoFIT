<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class PhysicalConnectionFtgwSourceFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName)
    {
        parent::__construct('physical_connection_ftgw_source', $options, $endpointSourceFieldsetServiceName, null);
    }

}
