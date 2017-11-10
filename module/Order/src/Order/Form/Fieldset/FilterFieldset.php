<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class FilterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {

        $this->add(
            [
                'name' => 'username',
                'type' => 'text',
                'options' => [
                    'label' => _('username'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-username'
                ]
            ]);

        $this->add(
            [
                'name' => 'change_number',
                'type' => 'text',
                'options' => [
                    'label' => _('change number'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control autocomplete-change-number'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'application_technical_short_name',
                'options' => [
                    'label' => _('application'),
                    'label_attributes' => [
                        'class' => 'col-md-4'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-application-number order-search-autocomplete-application'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}
