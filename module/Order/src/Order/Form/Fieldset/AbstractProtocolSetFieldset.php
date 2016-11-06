<?php
namespace Order\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DbSystel\DataObject\Protocol;

abstract class AbstractProtocolSetFieldset extends Fieldset implements InputFilterProviderInterface
{

}
