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
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-filename'
                ]
            ]);

        $this->add(
            [
                'name' => 'record_length',
                'type' => 'text',
                'options' => [
                    'label' => _('record length'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
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
                            'value' => FileParameter::BLOCKING_TYPE_VARIABLE,
                            'label' => FileParameter::BLOCKING_TYPE_VARIABLE,
                            'selected' => true
                        ],
                        [
                            'value' => FileParameter::BLOCKING_TYPE_FIXED,
                            'label' => FileParameter::BLOCKING_TYPE_FIXED
                        ]
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'field-blocking-type'
                ]
            ]);

        $this->add(
            [
                'name' => 'block_size',
                'type' => 'text',
                'options' => [
                    'label' => _('block size (only for fixed blocking)'),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control field-block-size'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
