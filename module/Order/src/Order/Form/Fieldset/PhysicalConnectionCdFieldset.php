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
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'count' => 1,
                    'should_create_template' => false,
                    'allow_add' => false,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\EndpointCdAs400Source',
                    ),
                ]
            ]);

        $this->add(
            [
                'name' => 'endpoint_target',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'count' => 1,
                    'should_create_template' => false,
                    'allow_add' => false,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\EndpointCdAs400Target',
                    ),
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'secure_plus' => [
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('application code'),
                'allow_empty' => true,
                'continue_if_empty' => true
            ]
        ];
    }
}
