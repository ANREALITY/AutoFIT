<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointFtgwWindowsSourceFieldset extends AbstractEndpointFtgwWindowsFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Source - Windows'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'notification_success',
                'options' => [
                    'label' => _('notification on success'),
                    'use_hidden_element' => false,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'notification_success',
                'options' => [
                    'label' => _('mail for success notification'),
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
                'name' => 'notification_failure',
                'options' => [
                    'label' => _('notification on failure'),
                    'use_hidden_element' => false,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'notification_failure',
                'options' => [
                    'label' => _('mail for failure notification'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_SOURCE;
    }

}
