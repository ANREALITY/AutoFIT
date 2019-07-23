<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Base\DataObject\Protocol;

abstract class AbstractProtocolSetFieldset extends Fieldset implements InputFilterProviderInterface
{

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
        foreach ($this->getProtocols() as $key => $value) {
            $valueOptions[] = [
                'value' => $key,
                'label' => $value
            ];
        }
        return $valueOptions;
    }

    protected function getProtocols()
    {
        return Protocol::PROTOCOLS;
    }

}
