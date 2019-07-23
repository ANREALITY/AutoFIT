<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Base\DataObject\LogicalConnection;

class LogicalConnectionCdFieldset extends AbstractLogicalConnectionFieldset
{

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_CD;
    }

}
