<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator\EmailAddress;

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
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'success',
                'options' => [
                    'label' => _('successful transfer'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-1 notification-checkbox'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'failure',
                'options' => [
                    'label' => _('failed transfer'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-1 notification-checkbox'
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required' => false,
                'filters'  => [
                    ['name' => 'Zend\Filter\StringTrim'],
                ],
                'validators' => [
                    new EmailAddress()
                ],
            ]
        ];
    }

}
