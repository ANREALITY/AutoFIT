<?php
namespace Order\Form\OrderSearch\Fieldset;

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
                    'label' => _('date of the ordering'),
                    'value_options' => [
                        [
                            'value' => Criteria::DESC,
                            'label' => _('▲'),
                            'selected' => true
                        ],
                        [
                            'value' => Criteria::ASC,
                            'label' => _('▼')
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
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
