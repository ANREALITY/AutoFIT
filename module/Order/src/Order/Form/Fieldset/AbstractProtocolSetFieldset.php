<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\Protocol;

abstract class AbstractProtocolSetFieldset extends Fieldset implements InputFilterProviderInterface
{

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
                    'value_options' => $this->getValueOptions()
                ]
            ]);
    }
    
    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'protocols' => [
                'required' => true
            ]
        ];
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
        return $valueOptions;
    }

}
