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
            [
                'type' => 'Order\Form\Fieldset\FileTransferRequest',
                'options' => [
                    'use_as_base_fieldset' => true
                ]
            ]);

        $this->add(
            [
                'name' => 'submit',
                'attributes' => [
                    'type' => 'submit',
                    'value' => _('send'),
                    'class' => 'btn btn-default'
                ]
            ]);
    }
}
