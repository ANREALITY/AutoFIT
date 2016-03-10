<?php
namespace FileTransferRequest\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ServiceInvoicePositionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Service Invoice Position'));

        $this->add(array(
            'type' => 'text',
            'name' => 'number',
            'options' => array(
                'label' => _('service invoice position number')
            )
        ));
        $this->add(array(
            'type' => 'text',
            'name' => 'numbersdfgds',
            'options' => array(
                'label' => _('service invoice position number')
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'number' => [
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
