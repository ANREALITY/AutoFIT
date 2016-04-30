<?php
namespace DbSystel\Form\Element;

use Zend\Form\Element\Checkbox as ZendCheckbox;

class Checkbox extends ZendCheckbox
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\Form\Element\Checkbox::getInputSpecification()
     */
    public function getInputSpecification()
    {
        $spec = parent::getInputSpecification();
        $spec['required'] = false;
        return $spec;
    }

}
