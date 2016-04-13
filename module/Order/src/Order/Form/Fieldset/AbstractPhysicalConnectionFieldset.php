<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractPhysicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    /**
     *
     * @var string
     */
    protected $endpointSourceFieldsetServiceName;

    /**
     *
     * @var string
     */
    protected $endpointTargetFieldsetServiceName;

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName = null,
        string $endpointTargetFieldsetServiceName = null)
    {
        parent::__construct('physical_connection', $options);

        $this->endpointSourceFieldsetServiceName = $endpointSourceFieldsetServiceName;
        $this->endpointTargetFieldsetServiceName = $endpointTargetFieldsetServiceName;
    }

    public function init()
    {
        if ($this->endpointSourceFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'endpoint_source',
                    'type' => $this->endpointSourceFieldsetServiceName,
                    'options' => []
                ]);
        }

        if ($this->endpointTargetFieldsetServiceName) {
            $this->add(
                [
                    'name' => 'endpoint_target',
                    'type' => $this->endpointTargetFieldsetServiceName,
                    'options' => []
                ]);
        }

        $this->add(
            [
                'name' => 'role',
                'type' => 'hidden',
                'attributes' => [
                    'required' => 'required',
                    'class' => 'form-control',
                    'value' => $this->getConcreteRole()
                ]
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
