<?php
namespace Order\Form;

use Zend\Form\Form;

class OrderForm extends Form
{

    public function __construct()
    {
        parent::__construct('create_file_transfer_request');
    }

    public function init()
    {
        $this->setAttribute('method', 'post');
        
        $this->add(
            array(
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
                    'value' => _('send')
                )
            ));
    }
}
