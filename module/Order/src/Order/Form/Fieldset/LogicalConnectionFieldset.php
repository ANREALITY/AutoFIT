<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

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
                'name' => 'physical_connections',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'count' => 1,
                    'should_create_template' => false,
                    'allow_add' => false,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\PhysicalConnectionCd'
                    ]
                ]
            ]); // @todo make it dynamic!
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
