<?php
namespace Order\Form\Fieldset;

class EndpointCdAs400TargetFieldset extends EndpointCdAs400Fieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // Hydrator and Prototype are set in the factory.
        // $this->setHydrator(new ClassMethods(false));
        // $this->setObject(new FileTransferRequest());

        $this->setLabel(_('Target - AS400'));

        $this->add(
            array(
                'type' => 'text',
                'name' => 'username',
                'options' => array(
                    'label' => _('username')
                )
            ));

        $this->add(
            array(
                'type' => 'text',
                'name' => 'folder',
                'options' => array(
                    'label' => _('folder')
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
            ],
            'folder' => [
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => 'Zend\Filter\StringTrim',
                        'options' => []
                    ]
                ],
                'validators' => [],
                'description' => _('application code'),
                'allow_empty' => false,
                'continue_if_empty' => false
            ]
        ];
    }
}
