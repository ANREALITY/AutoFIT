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
                    // @todo make it dynamic!
                    'value' => LogicalConnection::TYPE_CD
                ]
            ]);

        $this->add(
            [
                'name' => 'specific_physical_connections',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'count' => 1,
                    'should_create_template' => false,
                    'allow_add' => false,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\SpecificPhysicalConnectionCd',
                    ),
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
