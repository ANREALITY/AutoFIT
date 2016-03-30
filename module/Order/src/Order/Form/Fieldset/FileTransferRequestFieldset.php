<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_transfer_request', $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'name' => 'user',
                'type' => 'Order\Form\Fieldset\User',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'logical_connection',
                'type' => 'Order\Form\Fieldset\LogicalConnection',
                'options' => []
            ]);

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\ServiceInvoicePositionBasic',
                'name' => 'service_invoice_position_basic',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'application_number',
                'type' => 'text',
                'options' => [
                    'label' => _('application'),
                    'label_attributes' => []
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'id' => 'order' . '-' . 'application-number'
                ]
            ]);

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonal',
                'name' => 'service_invoice_position_personal',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'change_number' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[A-Z][0-9]{8}/',
                            'message' => _(
                                'Change numbers have the format 1 capital letter and 8 digits ("C12345678").')
                        ]
                    ]
                ]
            ],
            'application_number' => [
                'required' => true
            ]
        ];
    }

}
