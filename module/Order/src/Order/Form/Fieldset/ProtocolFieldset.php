<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class ProtocolFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('protocol', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'name',
                'type' => 'text',
                'options' => [
                    'label' => _('protocol name'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-protocol-name'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
