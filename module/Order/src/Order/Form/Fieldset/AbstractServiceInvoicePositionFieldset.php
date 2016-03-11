<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AbstractServiceInvoicePositionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);
    }

    public function init()
    {
        $this->setLabel(_('Service Invoice Position'));
        
        $this->add(
            [
                'type' => 'text',
                'name' => 'number',
                'options' => [
                    'label' => _('service invoice position number')
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'number' => [
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('service invoice position number'),
                'allow_empty' => false,
                'continue_if_empty' => false
            ]
        ];
    }
}
