<?php
namespace Order\Form\OrderSearch\Fieldset;

use Order\Form\Fieldset\AbstractServerFieldset;

class ServerCommonFieldset extends AbstractServerFieldset
{

    public function init()
    {
        parent::init();

        $this->get('name')->setLabelAttributes([
            'class' => 'col-md-4'
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => false,
                'validators' => []
            ]
        ];
    }

}
