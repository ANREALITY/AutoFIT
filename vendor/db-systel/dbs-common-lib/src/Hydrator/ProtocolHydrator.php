<?php
namespace DbSystel\Hydrator;

use Zend\Hydrator\ClassMethods;
use DbSystel\DataObject\Protocol;

class ProtocolHydrator extends ClassMethods
{
    /**
     * {@inheritDoc}
     * @see \Zend\Hydrator\ClassMethods::extract()
     */
    public function extract($object)
    {
        return $object->getName();
    }

    public function hydrate(array $data, $object)
    {
        // An array with one string value for the ID is expected, e.g.:
        // [HTTP]
        $dataValues = array_values($data);
        $name = array_shift($dataValues);
        return parent::hydrate(['name' => $name], $object);
    }
}
