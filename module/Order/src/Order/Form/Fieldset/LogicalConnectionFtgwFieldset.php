<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\LogicalConnection;

class LogicalConnectionFtgwFieldset extends AbstractLogicalConnectionFieldset
{

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_FTGW;
    }

}
