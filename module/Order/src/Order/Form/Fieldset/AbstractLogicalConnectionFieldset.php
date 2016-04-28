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
                    'class' => 'form-control',
                    'value' => $this->getConcreteType()
                ]
            ]);

        $this->add(
            [
                'name' => 'notifications',
                'type' => 'Zend\Form\Element\Collection',
                'options' => [
                    'label' => _('notifications'),
                    'count' => 1,
                    'should_create_template' => true,
                    'template_placeholder' => '__index__',
                    'allow_add' => true,
                    'target_element' => [
                        'type' => 'Order\Form\Fieldset\Notification',
                    ],
                    'label_attributes' => [
                        'class' => 'col-md-12'
                    ]
                ]
            ]);

        $this->add(
            [
                'name' => 'add_notification',
                'type' => 'button',
                'options' => [
                    'label' => _('+')
                ],
                'attributes' => [
                    'class' => 'btn btn-default',
                    'id' => 'add-notification-button',
                    'value' => _('add a notification')
                ],
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
    
    abstract protected function getConcreteType();

}
