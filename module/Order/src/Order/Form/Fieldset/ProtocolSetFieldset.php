<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\Protocol;

class ProtocolSetFieldset extends Fieldset implements InputFilterProviderInterface
{

    const PROTOCOLS_DUMMY_VALUE = 0;

    const PROTOCOLS_DUMMY_LABEL = 'dummy';

    public function __construct($name = null, $options = [])
    {
        parent::__construct('protocol_set', ['label' => _('protocols')]);
    }

    public function init()
    {
        $this->add(
            [
                'type' => 'multi_checkbox',
                'name' => 'protocols',
                'options' => [
                    'label' => _('protocols'),
                    'label_attributes' => [
                        'class' => 'col-md-1 protocol-field'
                    ],
                    'value_options' => $this->getValueOptions(),
                    'selected' => static::PROTOCOLS_DUMMY_VALUE
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [];
        return array_merge([], $inputFilterSpecification);
    }

    protected function getValueOptions()
    {
        $valueOptions = [];
        foreach (Protocol::PROTOCOLS as $key => $value) {
            $valueOptions[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        $valueOptions[] = [
            'value' => static::PROTOCOLS_DUMMY_VALUE,
            'label' => static::PROTOCOLS_DUMMY_LABEL,
            'selected' => true,
            'label_attributes' => [
                'class' => 'checkboxdummy'
            ]
        ];
        return $valueOptions;
    }

}
