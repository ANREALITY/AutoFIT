<?php
namespace FileTransferRequest\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class FileTransferRequestFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());

        $this->setLabel(_('file transfer request'));

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

        $this->add(array(
            'type' => 'text',
            'name' => 'service_invoice_position_basic_number',
            'options' => array(
                'label' => _('service invoice position (basic)')
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'user_username',
            'options' => array(
                'label' => _('username')
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'service_invoice_position_personal_number',
            'options' => array(
                'label' => _('service invoice position (personal)')
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'application_technical_short_name' => [
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
