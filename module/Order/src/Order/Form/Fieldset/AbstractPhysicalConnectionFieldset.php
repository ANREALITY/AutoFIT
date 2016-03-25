<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractPhysicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('physical_connection', $options);
    }

    public function init()
    {
        // @todo make it dynamic!
        $endpointType = 'CdAs400';
        if ($endpointType === 'CdAs400') {
            $endpointSourceFieldsetServiceName = 'Order\Form\Fieldset\EndpointCdAs400Source';
            $endpointTargetFieldsetServiceName = 'Order\Form\Fieldset\EndpointCdAs400Target';
        } elseif ($endpointType === 'CdTandem') {
            $endpointSourceFieldsetServiceName = 'Order\Form\Fieldset\EndpointCdTandemSource';
            $endpointTargetFieldsetServiceName = 'Order\Form\Fieldset\EndpointCdTandemTarget';
        } // ...

        $this->add(
            [
                'name' => 'endpoint_source',
                'type' => $endpointSourceFieldsetServiceName,
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'endpoint_target',
                'type' => $endpointTargetFieldsetServiceName,
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
