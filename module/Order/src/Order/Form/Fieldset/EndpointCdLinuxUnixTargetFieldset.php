<?php
namespace Order\Form\Fieldset;

use DbSystel\DataObject\AbstractEndpoint;

class EndpointCdLinuxUnixTargetFieldset extends AbstractEndpointCdLinuxUnixFieldset
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Target - LinuxUnix'));
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
                        'class' => 'col-md-12 required'
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
                'required' => true,
                'validators' => [
                    [
                        'name' => 'DbSystel\Validator\Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9,_+\-\.\/]*$/',
                            'patternUserFriendly' => '"a-z", "A-Z", "0-9", ",", "_", "+", "-", ".", "/"'
                        ]
                    ],
                ]
            ],
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractEndpoint::ROLE_TARGET;
    }

}
