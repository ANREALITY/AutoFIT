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
    protected $physicalConnectionSourceFieldsetServiceName;

    /**
     *
     * @var string
     */
    protected $physicalConnectionTargetFieldsetServiceName;

    public function __construct($name = null, $options = [], string $physicalConnectionSourceFieldsetServiceName, 
        string $physicalConnectionTargetFieldsetServiceName = null)
    {
        parent::__construct('logical_connection', $options);
        
        $this->physicalConnectionSourceFieldsetServiceName = $physicalConnectionSourceFieldsetServiceName;
        $this->physicalConnectionTargetFieldsetServiceName = $physicalConnectionTargetFieldsetServiceName;
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'physical_connection_source',
                'type' => $this->physicalConnectionSourceFieldsetServiceName,
                'options' => []
            ]);
        
        if ($this->physicalConnectionTargetFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'physical_connection_target',
                    'type' => $this->physicalConnectionTargetFieldsetServiceName,
                    'options' => []
                ]);
        }
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
