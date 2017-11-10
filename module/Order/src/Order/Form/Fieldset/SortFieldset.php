<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class SortFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add(
            [
                'type' => 'radio',
                'name' => 'datetime',
                'options' => [
                    'label' => _('date and time'),
                    'value_options' => [
                        [
                            'value' => 'desc',
                            'label' => _('descending'),
                            'selected' => true
                        ],
                        [
                            'value' => 'asc',
                            'label' => _('ascending')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'class' => ''
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return $inputFilterSpecification;
    }

}
