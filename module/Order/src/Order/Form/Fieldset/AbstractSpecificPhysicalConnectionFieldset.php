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
                'name' => 'basic_physical_connection',
                'type' => 'Order\Form\Fieldset\BasicPhysicalConnection',
                'options' => []
            ]);
    }

    public function getInputFilterSpecification()
    {
        return [];
    }
}
