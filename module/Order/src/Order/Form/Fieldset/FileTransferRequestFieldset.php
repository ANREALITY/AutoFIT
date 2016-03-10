<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('file_transfer_request', $options);

        $this->setLabel(_('File Transfer Request'));

        $this->add(array(
            'type' => 'text',
            'name' => 'application_technical_short_name',
            'options' => array(
                'label' => _('application')
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'change_number',
            'options' => array(
                'label' => _('change number')
            )
        ));

//         $this->add(array(
//             'type' => 'Order\Form\Fieldset\ServiceInvoicePositionBasicFieldset',
//             'name' => 'service_invoice_position_basic',
//             'options' => array(
//                 'label' => 'service invoice position (basic)',
//             ),
//         ));

//         $this->add(array(
//             'type' => 'Order\Form\Fieldset\UserFieldset',
//             'name' => 'user',
//             'options' => array(
//                 'label' => 'user',
//             ),
//         ));

//         $this->add(array(
//             'type' => 'Order\Form\Fieldset\ServiceInvoicePositionPersonalFieldset',
//             'name' => 'service_invoice_position_personal',
//             'options' => array(
//                 'label' => 'service invoice position (personal)',
//             ),
//         ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'change_number' => [
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('application code'),
                'allow_empty' => false,
                'continue_if_empty' => false
            ]
        ];
    }
}
