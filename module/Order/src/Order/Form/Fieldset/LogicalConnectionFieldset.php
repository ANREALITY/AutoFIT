<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\LogicalConnection;

class LogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct('logical_connection', $options);
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'type',
                'type' => 'hidden',
                'options' => [
                    'label' => _('type')
                ],
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => LogicalConnection::TYPE_CD
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'type' => [
                'required' => true
            ]
        ];
    }
}
