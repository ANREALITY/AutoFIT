<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class EndpointCdAs400Fieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setLabel(_('AS400'));
    }

    public function init()
    {
        $this->add(
            array(
                'type' => 'text',
                'name' => 'username',
                'options' => array(
                    'label' => _('username')
                )
            ));
    }

    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('username'),
                'allow_empty' => false,
                'continue_if_empty' => false
            ]
        ];
    }
}
