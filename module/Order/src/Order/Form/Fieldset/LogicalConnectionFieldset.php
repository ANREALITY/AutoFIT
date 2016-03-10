<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class LogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('logical_connection', $options);

        $this->setLabel(_('logical connection'));

        $this->add(array(
            'type' => 'hidden',
            'name' => 'id',
            'options' => array(
                'label' => _('user ID')
            )
        ));

        $this->add(array(
            'type' => 'text',
            'name' => 'type',
            'options' => array(
                'label' => _('type')
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('logical connection ID'),
                'allow_empty' => true,
                'continue_if_empty' => true
            ],
            'type' => [
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('logical connection type'),
                'allow_empty' => false,
                'continue_if_empty' => false
            ],
        ];
    }
}
