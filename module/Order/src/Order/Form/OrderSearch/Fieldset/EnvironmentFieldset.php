<?php
namespace Order\Form\OrderSearch\Fieldset;

use Order\Form\Fieldset\EnvironmentFieldset as OrderFormEnvironmentFieldset;

class EnvironmentFieldset extends OrderFormEnvironmentFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('environment', $options);
    }

    public function init()
    {
        parent::init();

        $this->get('name')->setLabelAttributes([
            'class' => ''
        ]);
        $this->get('name')->removeAttribute('required');
    }

    public function getInputFilterSpecification()
    {
        return [
            'severity' => [
                'validators' => []
            ]
        ];
    }

}
