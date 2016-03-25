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

    public function __construct($name = null, $options = [], string $endpointSourceFieldsetServiceName,
        string $endpointTargetFieldsetServiceName)
    {
        parent::__construct('physical_connection', $options);

        $this->endpointSourceFieldsetServiceName = $endpointSourceFieldsetServiceName;
        $this->endpointTargetFieldsetServiceName = $endpointTargetFieldsetServiceName;
    }

    public function init()
    {
        $this->add(
            [
                'name' => 'endpoint_source',
                'type' => $this->endpointSourceFieldsetServiceName,
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'endpoint_target',
                'type' => $this->endpointTargetFieldsetServiceName,
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
