<?php
namespace DbSystel\Hydrator;

use Zend\Hydrator\ClassMethods;
use DbSystel\DataObject\Protocol;

class ProtocolHydrator extends ClassMethods
{
    public function extract($object)
    {
        return $object->getId();
    }
}