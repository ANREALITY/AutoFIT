<?php
namespace FileTransferRequest\Form\Fieldset;

use DbSystel\DataObject\FileTransferRequest;
use Zend\Form\Fieldset;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilterProviderInterface;

class TargetFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());

        $this->setLabel(_('Target'));

        $this->add(array(
            'type' => 'text',
            'name' => 'contact_person',
            'options' => array(
                'label' => _('contact person')
            )
            /*,
            'attributes' => array(
                'required' => 'required',
            ),
            */
        ));

        $this->add(array(
            'type' => 'radio',
            'name' => 'server_place',
            'options' => array(
                'label' => _('server place'),
                'value_options' => array(
                    'intranet' => _('intranet'),
                    'internet' => _('internet'),
                )
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'application',
            'options' => array(
                'label' => _('application')
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'customer_name',
            'options' => array(
                'label' => _('customer')
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'server_plattform',
            'options' => array(
                'label' => _('server plattform'),
                'value_options' => array(
                    'AS400' => 'AS400',
                    'Tandem' => 'Tandem',
                )
            ),
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
            'name' => 'server_name',
            'options' => array(
                'label' => _('server name')
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
