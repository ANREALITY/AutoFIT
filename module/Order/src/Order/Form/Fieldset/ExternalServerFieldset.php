<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ExternalServerFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('external server'),
                    'label_attributes' => [
                        'class' => 'col-md-12 required-conditionally'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control input-external-server'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => false
            ]
        ];
    }

}
