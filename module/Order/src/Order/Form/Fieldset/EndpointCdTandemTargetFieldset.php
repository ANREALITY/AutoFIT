<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointCdTandemTargetFieldset extends AbstractEndpointCdTandemFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - Tandem'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
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
                    'class' => 'form-control field-folder'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'folder' => [
                'required' => true
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_TARGET;
    }

}
