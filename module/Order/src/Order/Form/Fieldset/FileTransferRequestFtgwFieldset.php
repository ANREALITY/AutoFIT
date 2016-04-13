<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\LogicalConnection;

class FileTransferRequestFtgwFieldset extends AbstractFileTransferRequestFieldset
{

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_FTGW;
    }

}
