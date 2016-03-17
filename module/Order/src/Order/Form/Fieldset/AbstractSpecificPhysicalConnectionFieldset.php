<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AbstractSpecificPhysicalConnectionFieldset extends Fieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct('specific_physical_connection', $options);
    }

    public function init()
    {
        parent::init();
        
        $this->add(
            [
                'name' => 'specific_endpoint_source',
                'type' => 'Order\Form\Fieldset\SpecificEndpointCdAs400Source',
                'options' => []
            ]);
        
        $this->add(
            [
                'name' => 'specific_endpoint_target',
                'type' => 'Order\Form\Fieldset\SpecificEndpointCdAs400Target',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
