<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\LogicalConnection;

class FileTransferRequestCdFieldset extends AbstractFileTransferRequestFieldset
{

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_CD;
    }

}
