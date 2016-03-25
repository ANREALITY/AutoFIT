<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class PhysicalConnectionCdFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('physical_connection_cd', $options);
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'secure_plus',
                'options' => [
                    'label' => _('Secure Plus'),
                    'use_hidden_element' => false,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                ]
            ]);
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
