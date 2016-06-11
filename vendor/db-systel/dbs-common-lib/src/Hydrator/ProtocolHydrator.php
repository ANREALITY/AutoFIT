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
        return $object->getId();
    }

    public function hydrate(array $data, $object)
    {
        // An array with one int value for the ID is expected, e.g.:
        // [123]
        $dataValues = array_values($data);
        $id = array_shift($dataValues);
        return parent::hydrate(['id' => $id], $object);
    }
}
