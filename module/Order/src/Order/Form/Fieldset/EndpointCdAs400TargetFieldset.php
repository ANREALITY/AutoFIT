<?php
namespace Order\Form\Fieldset;

class EndpointCdAs400TargetFieldset extends EndpointCdAs400Fieldset
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        
        $this->setLabel(_('Target - AS400'));
    }

    public function init()
    {
        parent::init();
        
        $this->add(
            array(
                'type' => 'text',
                'name' => 'folder',
                'options' => [
                    'label' => _('folder'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control'
                ]
            ));

        $this->add(
            [
                'type' => 'Order\Form\Fieldset\EndpointCdTarget',
                'name' => 'endpoint',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'folder' => [
                'required' => true,
            ]
        ];
    }
}
