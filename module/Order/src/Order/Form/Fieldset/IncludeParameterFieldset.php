<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class IncludeParameterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('include_parameter', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'expression',
                'type' => 'text',
                'options' => [
                    'label' => _('expression'),
                    'label_attributes' => [
                        'class' => 'col-md-11 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-expression'
                ]
            ]);

        $this->add(
            [
                'name' => 'remove-include-parameter',
                'type' => 'button',
                'options' => [
                    'label' => '–'
                ],
                'attributes' => [
                    'class' => 'btn btn-default button-remove remove-include-parameter-button',
                    'value' => _('remove an include parameter')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'expression' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'max' => 50
                        ]
                    ],
                ]
            ],
        ];
    }

}
