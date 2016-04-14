<?php
namespace Order\Form;

use Zend\Form\Form;

class OrderForm extends Form
{
    
    protected $fileTransferRequestFieldsetServiceName;

    public function __construct($name = null, $options = [], string $fileTransferRequestFieldsetServiceName)
    {
        parent::__construct('create_file_transfer_request');
        
        $this->fileTransferRequestFieldsetServiceName = $fileTransferRequestFieldsetServiceName;
    }

    public function init()
    {
        $this->setAttribute('method', 'post');

        $this->add(
            [
                'type' => $this->fileTransferRequestFieldsetServiceName,
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('binding order'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }

}
