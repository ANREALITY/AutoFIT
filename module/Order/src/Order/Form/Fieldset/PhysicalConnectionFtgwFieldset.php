<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class PhysicalConnectionFtgwFieldset extends AbstractPhysicalConnectionFieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('physical_connection_ftgw', $options);
    }
}
