<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class LogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     *
     * @var string
     */
    protected $physicalConnectionServiceName;

    public function __construct($name = null, $options = [], string $physicalConnectionServiceName)
    {
        parent::__construct('logical_connection', $options);

        $this->physicalConnectionServiceName = $physicalConnectionServiceName;
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
                        'type' => $this->physicalConnectionServiceName
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
