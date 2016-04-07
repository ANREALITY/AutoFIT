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
            'type' => 'hidden',
            'attributes' => [
                'id' => 'order' . '-' . 'environment-severity'
            ]
        ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'name',
                'options' => [
                    'label' => _('environment')
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'order' . '-' . 'environment-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
