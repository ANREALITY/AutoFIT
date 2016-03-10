<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('user', $options);

        $this->setLabel(_('user'));

        $this->add(array(
            'type' => 'hidden',
            'name' => 'id',
            'options' => array(
                'label' => _('user ID')
            )
        ));

        $this->add(array(
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
            'id' => [
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('user ID'),
                'allow_empty' => true,
                'continue_if_empty' => true
            ],
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
            ],
        ];
    }
}
