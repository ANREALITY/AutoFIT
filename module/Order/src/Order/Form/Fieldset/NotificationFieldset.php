<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class NotificationFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('notification', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'email',
                'type' => 'text',
                'options' => [
                    'label' => _('email'),
                    'label_attributes' => [
                        'class' => 'col-md-7'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'success',
                'options' => [
                    'label' => _('successful'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-2 notification-checkbox'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'failure',
                'options' => [
                    'label' => _('failed'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-2 notification-checkbox'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'remove-notification',
                'type' => 'button',
                'options' => [
                    'label' => '–'
                ],
                'attributes' => [
                    'class' => 'btn btn-default button-remove remove-notification-button',
                    'value' => _('remove a notification')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Zend\Filter\StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'EmailAddress'
                    ]
                ]
            ]
        ];
    }

}
