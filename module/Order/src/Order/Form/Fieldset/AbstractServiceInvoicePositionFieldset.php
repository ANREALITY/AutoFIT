<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractServiceInvoicePositionFieldset extends Fieldset implements InputFilterProviderInterface
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
                'name' => 'number',
                'options' => [
                    'label' => _('service invoice position number'),
                    'label_attributes' => [
                        'class' => 'required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'number' => [
                'required' => true
            ]
        ];
    }

}
