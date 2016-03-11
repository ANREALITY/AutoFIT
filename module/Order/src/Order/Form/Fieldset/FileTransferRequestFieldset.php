<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class FileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_transfer_request', $options);
    }

    public function init()
    {
        $this->setHydrator(new ClassMethods())->setObject(new FileTransferRequest());
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        
        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);
        
        $this->add(
            [
                'name' => 'user',
                'type' => 'Order\Form\Fieldset\UserFieldset',
                'options' => [
                    'label' => _('user of the file transfer request')
                ]
            ]);
        
        $this->add(
            [
                'name' => 'logical_connection',
                'type' => 'Order\Form\Fieldset\LogicalConnectionFieldset',
                'options' => [
                    'label' => _('logical connection of the file transfer request')
                ]
            ]);
        
        // $this->add([
        // 'type' => 'Order\Form\Fieldset\ServiceInvoicePositionBasicFieldset',
        // 'name' => 'service_invoice_position_basic',
        // 'options' => [
        // 'label' => _('service invoice position (basic)'),
        // ),
        // ));
        
        $this->add(
            [
                'name' => 'application_number',
                'type' => 'text',
                'options' => [
                    'label' => _('application')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);
        
        // $this->add([
        // 'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonalFieldset',
        // 'name' => 'service_invoice_position_personal',
        // 'options' => [
        // 'label' => _('service invoice position (personal)'),
        // ),
        // ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'change_number' => [
                'required' => true
            ],
            'application_number' => [
                'required' => true
            ]
        ];
    }
}
