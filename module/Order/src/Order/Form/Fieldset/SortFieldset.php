<?php
namespace Order\Form\Fieldset;

use Doctrine\Common\Collections\Criteria;
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
                    'label' => _('date and time of the ordering'),
                    'value_options' => [
                        [
                            'value' => Criteria::DESC,
                            'label' => _('descending'),
                            'selected' => true
                        ],
                        [
                            'value' => Criteria::ASC,
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
