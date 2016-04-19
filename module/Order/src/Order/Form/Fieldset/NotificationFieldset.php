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
                'name' => 'event_success',
                'options' => [
                    'label' => _('successful transfer'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-1'
                    ]
                ]
            ]);

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'event_failure',
                'options' => [
                    'label' => _('failed transfer'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                    'label_attributes' => [
                        'class' => 'col-md-1'
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
