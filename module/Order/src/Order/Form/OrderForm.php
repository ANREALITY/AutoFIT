<?php
namespace Order\Form;

use Zend\Form\Form;

class OrderForm extends Form
{

    public function __construct()
    {
        parent::__construct('order');
        
        $this->add(
            array(
                'name' => 'file_transfer_request',
                'type' => 'Order\Form\Fieldset\FileTransferRequestFieldset',
                'options' => array(
                    'use_as_base_fieldset' => true
                )
            ));
        
        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => 'Send'
                )
            ));
    }
}
