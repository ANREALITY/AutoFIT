<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractLogicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
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

        $this->add(
            [
                'name' => 'type',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteType()
                ]
            ]);

        $this->add(
            [
                'name' => 'notifications',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'count' => 5,
                    'should_create_template' => true,
                    'template_placeholder' => '__placeholder__',
                    'allow_add' => true,
                    'target_element' => array(
                        'type' => 'Order\Form\Fieldset\Notification',
                    ),
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
    
    abstract protected function getConcreteType();

}
