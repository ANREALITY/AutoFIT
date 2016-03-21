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
        $this->add(
            [
                'name' => 'endpoint_source',
                'type' => 'Order\Form\Fieldset\EndpointCdAs400Source',
                'options' => []
            ]);

        $this->add(
            [
                'name' => 'endpoint_target',
                'type' => 'Order\Form\Fieldset\EndpointCdAs400Target',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
