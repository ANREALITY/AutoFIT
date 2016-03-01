<?php
namespace FileTransferRequest\Form;

use Zend\Form\Form;

class FileTransferRequestForm extends Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->init();
    }

    public function init()
    {
    }
}
