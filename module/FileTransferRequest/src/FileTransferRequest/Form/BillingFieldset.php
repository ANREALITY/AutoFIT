<?php
namespace FileTransferRequest\Form;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class BillingFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());
        
        $this->setLabel(_('Billing'));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'application',
            'options' => array(
                'label' => _('application')
            )
            /*,
            'attributes' => array(
                'required' => 'required',
            ),
            */
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'service_invoice_position_basic_number',
            'options' => array(
                'label' => _('service invoice position number (basic)')
            )
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'service_invoice_position_personal_number',
            'options' => array(
                'label' => _('service invoice position number (personal)')
            )
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'change_number',
            'options' => array(
                'label' => _('change number')
            )
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'username',
            'options' => array(
                'label' => _('username')
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'application' => [
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
