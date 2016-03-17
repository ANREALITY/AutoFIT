<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class SpecificPhysicalConnectionCdFieldset extends AbstractSpecificPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('specific_physical_connection_cd', $options);
    }

    public function init()
    {
        parent::init();

        $this->add(
            array(
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'secure_plus',
                'options' => array(
                    'label' => _('Secure Plus'),
                    'use_hidden_element' => false,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                )
            ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'secure_plus' => [
                'required' => false
            ]
        ];
    }
}
