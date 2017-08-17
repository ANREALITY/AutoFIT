<?php
namespace DbSystel\DataObject;

/**
 * Class AbstractDataObject
 *
 * @package DbSystel\DataObject
 */
class AbstractDataObject implements \JsonSerializable
{

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        $keys = array_keys($vars);
        $values = array_values($vars);
        $keysUnderscored = preg_replace_callback('/([A-Z])/', function($matches) {
            return '_' . strtolower($matches[1]);
        }, $keys);
        $varsUnderscored = array_combine($keysUnderscored, $values);
        return $varsUnderscored;
    }

}
