<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class SpecificPhysicalConnectionFtgwFieldset extends AbstractSpecificPhysicalConnectionFieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct('specific_physical_connection_ftgw', $options);
    }
}
