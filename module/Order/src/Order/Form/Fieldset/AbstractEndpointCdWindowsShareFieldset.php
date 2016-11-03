<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\AbstractEndpoint;

abstract class AbstractEndpointCdWindowsShareFieldset extends AbstractEndpointFieldset implements
    InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('WindowsShare'));
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'text',
                'name' => 'sharename',
                'options' => [
                    'label' => _('sharename'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-folder'
                ]
            ]);

        $this->add(
            [
                'type' => 'text',
                'name' => 'folder',
                'options' => [
                    'label' => _('interface directory'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control'
                ]
            ]);

        $this->add(
            [
                'name' => 'access_config_set',
                'type' => 'Order\Form\Fieldset\AccessConfigSet',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'sharename' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 4,
                            'max' => 13
                        ]
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9]*$/'
                        ]
                    ],
                ]
            ],
            'folder' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 15
                        ]
                    ],
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9-]*$/'
                        ]
                    ],
                ]
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteType()
    {
        return AbstractEndpoint::TYPE_CD_WINDOWS_SHARE;
    }

}
