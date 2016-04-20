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
                    'label' => _(' '),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
