<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EnvironmentFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('customer', $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'severity',
            'type' => 'hidden'
        ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('environment'),
                    'label_attributes' => [
                        'class' => 'col-md-6'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
