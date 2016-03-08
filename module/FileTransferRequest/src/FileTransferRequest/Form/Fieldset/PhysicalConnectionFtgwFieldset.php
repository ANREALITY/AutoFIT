<?php
namespace FileTransferRequest\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;

class PhysicalConnectionFtgwFieldset extends PhysicalConnectionFieldset
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setLabel(_('File Transfer Gateway connection settings'));
    }
}
