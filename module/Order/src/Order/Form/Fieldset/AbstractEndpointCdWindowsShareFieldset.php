<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Base\DataObject\AbstractEndpoint;

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
                        'class' => 'col-md-12 required'
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
                        'class' => 'col-md-12 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
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
                            'max' => 15
                        ]
                    ],
                    [
                        'name' => 'Base\Validator\Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9_]*$/',
                            'patternUserFriendly' => '"a-z", "A-Z", "0-9", "_"'
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
                            'max' => 20
                        ]
                    ],
                    [
                        'name' => 'Base\Validator\Regex',
                        'options' => [
                            'pattern' => '/^[a-zA-Z0-9_\-]*$/',
                            'patternUserFriendly' => '"a-z", "A-Z", "0-9", "_", "-"'
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
