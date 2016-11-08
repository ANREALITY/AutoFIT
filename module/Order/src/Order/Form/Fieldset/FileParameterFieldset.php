<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\FileParameter;

class FileParameterFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('file_parameter', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'filename',
                'type' => 'text',
                'options' => [
                    'label' => _('filename'),
                    'label_attributes' => [
                        'class' => 'col-md-11 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-filename'
                ]
            ]);

        $this->add(
            [
                'name' => 'remove-file-parameter',
                'type' => 'button',
                'options' => [
                    'label' => '–'
                ],
                'attributes' => [
                    'class' => 'btn btn-default button-remove remove-file-parameter-button',
                    'value' => _('remove an file parameter')
                ]
            ]);

        $this->add(
            [
                'name' => 'record_length',
                'type' => 'text',
                'options' => [
                    'label' => _('record length'),
                    'label_attributes' => [
                        'class' => 'col-md-11 required'
                    ]
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control field-record-length'
                ]
            ]);

        $this->add(
            [
                'type' => 'radio',
                'name' => 'blocking',
                'options' => [
                    'label' => _('blocking'),
                    'value_options' => [
                        [
                            'value' => FileParameter::BLOCKING_VARIABLE,
                            'label' => FileParameter::BLOCKING_VARIABLE,
                            'selected' => true
                        ],
                        [
                            'value' => FileParameter::BLOCKING_FIXED,
                            'label' => FileParameter::BLOCKING_FIXED
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-11'
                    ]
                ],
                'attributes' => [
                    'class' => 'field-blocking'
                ]
            ]);

        $this->add(
            [
                'name' => 'block_size',
                'type' => 'text',
                'options' => [
                    'label' => _('block size (only for fixed blocking)'),
                    'label_attributes' => [
                        'class' => 'col-md-11'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-block-size'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'filename' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Regex',
                        'options' => [
                            'pattern' => '/^[A-Z0-9\.]*$/'
                        ]
                    ],
                ]
            ],
            'record_length' => [
                'required' => true,
                'validators' => [
                    [
                        'name' => 'Digits'
                    ],
                    [
                        'name' => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 27926
                        ]
                    ]
                ]
            ],
            'block_size' => [
                'validators' => [
                    [
                        'name' => 'Digits'
                    ],
                    [
                        'name' => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 27930
                        ]
                    ]
                ]
            ],
        ];
    }

}
