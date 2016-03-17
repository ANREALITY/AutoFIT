<?php
namespace Order\Form\Fieldset;

class SpecificEndpointCdAs400TargetFieldset extends AbstractSpecificEndpointCdAs400Fieldset
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
                'type' => 'Order\Form\Fieldset\BasicEndpointCdTarget',
                'name' => 'basic_endpoint',
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
