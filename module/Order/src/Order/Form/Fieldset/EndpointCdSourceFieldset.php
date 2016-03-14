<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;

class EndpointCdSourceFieldset extends EndpointCdFieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - basic settings'));
    }
}
