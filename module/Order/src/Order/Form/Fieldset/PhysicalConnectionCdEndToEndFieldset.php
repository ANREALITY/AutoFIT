<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\LogicalConnection;

class PhysicalConnectionCdEndToEndFieldset extends AbstractPhysicalConnectionFieldset
{

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName,
        string $endpointTargetFieldsetServiceName)
    {
        parent::__construct('physical_connection_cd_end_to_end', $options, $endpointSourceFieldsetServiceName,
            $endpointTargetFieldsetServiceName);
    }

    public function init()
    {
        parent::init();

        $this->add(
            [
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'secure_plus',
                'options' => [
                    'label' => _('Secure Plus'),
                    'use_hidden_element' => true,
                    'checked_value' => '1',
                    'unchecked_value' => '0'
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        $inputFilterSpecification = [
            'secure_plus' => [
                'required' => true
            ]
        ];
        return array_merge(parent::getInputFilterSpecification(), $inputFilterSpecification);
    }

    protected function getConcreteRole()
    {
        return AbstractPhysicalConnection::ROLE_END_TO_END;
    }

    protected function getConcreteType()
    {
        return LogicalConnection::TYPE_CD;
    }

}
