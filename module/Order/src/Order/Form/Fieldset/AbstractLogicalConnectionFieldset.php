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
    protected $physicalConnectionEndToEndFieldsetServiceName;

    /**
     *
     * @var string
     */
    protected $physicalConnectionEndToMiddleFieldsetServiceName;

    /**
     *
     * @var string
     */
    protected $physicalConnectionMiddleToEndFieldsetServiceName;

    public function __construct($name = null, $options = [], string $physicalConnectionEndToEndFieldsetServiceName = null,
        string $physicalConnectionEndToMiddleFieldsetServiceName = null, string $physicalConnectionMiddleToEndFieldsetServiceName = null)
    {
        parent::__construct('logical_connection', $options);

        $this->physicalConnectionEndToEndFieldsetServiceName = $physicalConnectionEndToEndFieldsetServiceName;
        $this->physicalConnectionEndToMiddleFieldsetServiceName = $physicalConnectionEndToMiddleFieldsetServiceName;
        $this->physicalConnectionMiddleToEndFieldsetServiceName = $physicalConnectionMiddleToEndFieldsetServiceName;
    }

    public function init()
    {
        if ($this->physicalConnectionEndToEndFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'physical_connection_end_to_end',
                    'type' => $this->physicalConnectionEndToEndFieldsetServiceName,
                    'options' => []
                ]);
        }

        if ($this->physicalConnectionEndToMiddleFieldsetServiceName && $this->physicalConnectionMiddleToEndFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'physical_connection_end_to_middle',
                    'type' => $this->physicalConnectionEndToMiddleFieldsetServiceName,
                    'options' => []
                ]);
            $this->add(
                [
                    'name' => 'physical_connection_middle_to_end',
                    'type' => $this->physicalConnectionMiddleToEndFieldsetServiceName,
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
                        'type' => 'Order\Form\Fieldset\Notification'
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
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

    abstract protected function getConcreteType();

}
