<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

abstract class AbstractEndpointFtgwWindowsFieldset extends AbstractEndpointFieldset implements InputFilterProviderInterface
{

    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->setLabel(_('Windows'));
    }

    public function init()
    {
        parent::init();
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}
