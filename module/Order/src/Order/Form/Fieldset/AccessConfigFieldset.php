<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AccessConfigFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('access_config', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'permission_read',
                'options' => [
                    'label' => _('read'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-2 permission-checkbox'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'permission_write',
                'options' => [
                    'label' => _('write'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-2 permission-checkbox'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'permission_delete',
                'options' => [
                    'label' => _('delete'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-2 permission-checkbox'
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
