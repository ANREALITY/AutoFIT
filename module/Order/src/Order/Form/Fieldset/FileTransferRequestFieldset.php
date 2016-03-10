<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class FileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('file_transfer_request', $options);

        $this->setHydrator(new ClassMethods())->setObject(new FileTransferRequest());

        $this->add(array(
            'name' => 'id',
            'type' => 'hidden'
        ));

        $this->add(
            array(
                'name' => 'change_number',
                'type' => 'text',
                'options' => array(
                    'label' => _('change number')
                ),
                'attributes' => array(
                    'required' => 'required',
                    'class' => 'form-control'
                )
            ));

        $this->add(
            array(
                'name' => 'user',
                'type' => 'Order\Form\Fieldset\UserFieldset',
                'options' => array(
                    'label' => _('user of the file transfer request')
                )
            ));

        $this->add(
            array(
                'name' => 'logical_connection',
                'type' => 'Order\Form\Fieldset\LogicalConnectionFieldset',
                'options' => array(
                    'label' => _('logical connection of the file transfer request')
                )
            ));

        // $this->add(array(
        // 'type' => 'Order\Form\Fieldset\ServiceInvoicePositionBasicFieldset',
        // 'name' => 'service_invoice_position_basic',
        // 'options' => array(
        // 'label' => _('service invoice position (basic)'),
        // ),
        // ));

        $this->add(
            array(
                'name' => 'application_number',
                'type' => 'Order\Form\Fieldset\UserFieldset',
                'options' => array(
                    'label' => _('application')
                )
            ));

        // $this->add(array(
        // 'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonalFieldset',
        // 'name' => 'service_invoice_position_personal',
        // 'options' => array(
        // 'label' => _('service invoice position (personal)'),
        // ),
        // ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'change_number' => array(
                'required' => true
            )
        );
    }
}
