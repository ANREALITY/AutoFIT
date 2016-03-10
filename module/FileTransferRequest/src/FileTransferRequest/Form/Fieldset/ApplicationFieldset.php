<?php
namespace FileTransferRequest\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class ApplicationFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());

        $this->setLabel(_('Application'));

        $this->add(array(
            'type' => 'text',
            'name' => 'technical_short_name',
            'options' => array(
                'label' => _('application')
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'technical_short_name' => [
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
