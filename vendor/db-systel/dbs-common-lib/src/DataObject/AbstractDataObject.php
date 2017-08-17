<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractDataObject
 */
class AbstractDataObject implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();
        $members = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $members[$property->getName()] = $property->getValue($this);
        }
        $keys = array_keys($members);
        $values = array_values($members);
        $keysUnderscored = preg_replace_callback('/([A-Z])/', function($matches) {
            return '_' . strtolower($matches[1]);
        }, $keys);
        $varsUnderscored = array_combine($keysUnderscored, $values);
        return $varsUnderscored;
    }

}
