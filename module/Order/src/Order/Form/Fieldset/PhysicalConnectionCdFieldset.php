<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;

class PhysicalConnectionCdFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('physical_connection_cd', $options);
    }

    public function init()
    {
        parent::init();
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'secure_plus',
            'options' => array(
                'label' => _('Secure Plus'),
                'use_hidden_element' => false,
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
        ));

        $this->add(
            [
                'name' => 'endpoint_source',
                'type' => 'Order\Form\Fieldset\EndpointCdAs400Source',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'endpoint_target',
                'type' => 'Order\Form\Fieldset\EndpointCdAs400Target',
                'options' => []
            ]);
        
    }

    public function getInputFilterSpecification()
    {
        return [
            'secure_plus' => [
                'required' => false,
            ]
        ];
    }
}
