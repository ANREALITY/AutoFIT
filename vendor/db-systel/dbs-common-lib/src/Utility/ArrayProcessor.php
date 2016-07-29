<?php
namespace DbSystel\Utility;

class ArrayProcessor
{

    /**
     * @var string
     */
    protected $implodeSeparator;

    public function __construct($implodeSeparator = null)
    {
        $this->setImplodeSeparator($implodeSeparator);
    }

    /**
     * @return the $implodeSeparator
     */
    public function getImplodeSeparator()
    {
        return $this->implodeSeparator;
    }

    /**
     * @param string $implodeSeparator
     */
    public function setImplodeSeparator(string $implodeSeparator = null)
    {
        $this->implodeSeparator = $implodeSeparator;
    }

    public function isProperRow(array $row, callable $dataObjectCondition = null, $identifier = null, $prefix = null)
    {
        $isProper = false;
        $conditionOk = true;
        if ($dataObjectCondition && ! $dataObjectCondition($row)) {
            $conditionOk = false;
        }
        // Preventing creating empty objects.
        // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
        $identifierOk = true;
        if (is_string($identifier)) {
            $identifierOk = ! ($row[$prefix . $identifier] === '' || $row[$prefix . $identifier] === null);
        } elseif (is_array($identifier)) {
            foreach ($identifier as $key => $partIdentifierValue) {
                if ($row[$prefix[$key] . $partIdentifierValue] === '' || $row[$prefix[$key] . $partIdentifierValue] === null) {
                    $identifierOk = false;
                    break;
                }
            }
        }
        $isProper = $conditionOk && $identifierOk;
        return $isProper;
    }

    public function isProperColumn(string $columnAlias, $prefixes)
    {
        $prefixIsProper = false;
        if (is_string($prefixes)) {
            if (! empty($prefixes) && strpos($columnAlias, $prefixes) === 0) {
                $prefixIsProper = true;
            }
        } elseif (is_array($prefixes)) {
            foreach ($prefixes as $prefix) {
                if (! empty($prefix) && strpos($columnAlias, $prefix) === 0) {
                    $prefixIsProper = true;
                    break;
                }
            }
        }
        return $prefixIsProper;
    }

    /**
     * Returns the input array with only unique sub-arrays.
     * To determinate the uniqueness of the sub-arrays
     * following logic is applied:
     * A sub-array $foo is identical to another sub-array $bar,
     * if the value(-s) of the $identifier element(-s) in $foo
     * equals to the value(-s) of the correspondent element(-s) in $bar.
     *
     * @param array $array
     * @param mixed $identifier A value allowed as an array element's key or an array of such values.
     */
    public function arrayUniqueByIdentifier(array $array, $identifier)
    {
        if (is_string($identifier)) {
            $arrayUnique = $this->arrayUniqueBySingleIdentifier($array, $identifier);
        } elseif (is_array($identifier)) {
            $arrayUnique = $this->arrayUniqueByMultipleIdentifiers($array, $identifier);
        }
        return $arrayUnique;
    }

    /**
     * Returns the input array with only unique sub-arrays.
     * To determinate the uniqueness of the sub-arrays
     * following logic is applied:
     * A sub-array $foo is identical to another sub-array $bar,
     * if the value of the $identifier element in $foo
     * equals to the value of the correspondent element in $bar.
     *
     * @param array $array
     * @param string $identifier A value allowed as an array element's key.
     */
    protected function arrayUniqueBySingleIdentifier(array $array, string $identifier)
    {    
        // Get the grouping column array unique.
        $ids = array_keys($array);
        $identifierColumn = array_column($array, $identifier);
        $identifierColumnWithIds = array_combine($ids, $identifierColumn);
        $identifierColumnUnique = array_unique($identifierColumnWithIds);
        $ids = $identifierColumnUnique;

        // Filter the original array by the keys of the grouping column array.
        $arrayUnique = array_filter($array,
            function ($value, $key) use($ids, $array) {
                return in_array($key, array_keys($ids), true);
            }, ARRAY_FILTER_USE_BOTH);

        return $arrayUnique;
    }

    /**
     * Returns the input array with only unique sub-arrays.
     * To determinate the uniqueness of the sub-arrays
     * following logic is applied:
     * A sub-array $foo is identical to another sub-array $bar,
     * if the values of the $identifier elements in $foo
     * equals to the values of the correspondent elements in $bar.
     *
     * @param array $array
     * @param array $identifier An array of values, that are allowed as array element's keys.
     */
    protected function arrayUniqueByMultipleIdentifiers(array $table, array $identifiers)
    {
        $arrayForMakingUniqueByRow = $this->removeArrayColumns($table, $identifiers, true);
        $arrayUniqueBySubArray = $this->arrayUniqueBySubArray($arrayForMakingUniqueByRow);
        $arrayUnique = array_intersect_key($table, $arrayUniqueBySubArray);
        return $arrayUnique;
    }

    /**
     * Considering the multidimensional input array as a table,
     * removes some of its columns,
     * means the second-level elements with the specified keys.
     * If $isWhitelist is TRUE, all $columnNames are removed.
     * Else these are on the "whitelist" and the other are removed.
     *
     * @param array $table
     * @param array $columnNames
     * @param bool $isWhitelist
     * @return array
     */
    public function removeArrayColumns(array $table, array $columnNames, bool $isWhitelist = false)
    {
        foreach ($table as $rowKey => $row) {
            if (is_array($row)) {
                    foreach ($row as $fieldName => $fieldValue) {
                        $remove = $isWhitelist
                            ? !in_array($fieldName, $columnNames)
                            : in_array($fieldName, $columnNames)
                        ;
                        if ($remove) {
                            unset($table[$rowKey][$fieldName]);
                        }
                    }
            }
        }

        return $table;
    }

    /**
     * Extracts from the input $table the unique sub-arrays.
     *
     * For uniqueness check the sub-arrays get "stringified" first.
     * The IDs of the unique result strings are then the IDs of the unique sub-arrays.
     *
     * @see ArrayProcessor#stringifySubArrays(...)
     *
     * @param array $table
     */
    public function arrayUniqueBySubArray(array $table = [])
    {
        $elementStrings = $this->stringifySubArrays($table);
        $elementStringsUnique = array_unique($elementStrings);
        $table = array_intersect_key($table, $elementStringsUnique);
        return $table;
    }

    /**
     * Makes from every sub-array a string from its elements
     * (flattened and separated by the $this->implodeSeparator)
     * and returns an array of these "strigified" sub-arrays.
     * The indexes of the stringified sub-arrays remain the same
     *  as the indexes of the original sub-array elements.
     *
     * @see ArrayProcessor#flattenArray(...)
     * @see ArrayProcessor#stringifyArray(...)
     *
     * @param array $array
     */
    public function stringifySubArrays(array $array) {
        $elementStrings = [];
        foreach ($array as $key => $subArray) {
            $elementStrings[$key] = $this->stringifyArray($subArray);
        }
        return $elementStrings;
    }

    /**
     * "Flatten" the input $array first
     * (in order to avoid notices like "Array to string conversion")
     * and returns a string from its elements separated by the $implodeSeparator.
     * 
     * TRUE becomes '1', FALSE becomes '', NULL becomes ''.
     *
     * @see ArrayProcessor#flattenArray(...)
     *
     * @param array $array
     * @param string $implodeSeparator
     */
    public function stringifyArray(array $array, string $implodeSeparator = null)
    {
        $implodeSeparator = $implodeSeparator ?: $this->implodeSeparator;
        $elementPreparedForImplode = $this->flattenArray($array);
        return implode($implodeSeparator, $elementPreparedForImplode);
    }

    /**
     * Iterates through the input $array,
     * makes all its elements "flat",
     * and returnes the result.
     *
     * @see ArrayProcessor#flattenVar(...)
     *
     * @todo Make aware against cases with non-array elements
     *  (like: $elementStrings[] = is_array($subArray) ? stringify... : $subArray;).
     * 
     *
     * @param array $array
     */
    public function flattenArray(array $array) {
        $flatArray = array_map([$this, 'flattenVar'], $array);
        return $flatArray;
    }

    /**
     * Makes the input $var "flat".
     * If it's from a simply type like string or integer or from type NULL,
     * the value is returned.
     * If it's an object or an array, "object" or "array" is returned.
     *
     * @see gettype()
     *
     * @todo Maybe it would be make sence to return the (qualified?) classname for objects.
     * @todo Meybe create a Stringifyable interface, in order to allow nested "stringification".
     *
     * @param mixed $var
     * @return mixed
     */
    public function flattenVar($var) {
        $valueType = gettype($var);
        $simpleTypes = ['boolean', 'integer', 'double', 'float', 'string', 'NULL'];
        $var = in_array($valueType, $simpleTypes) ? $var : $valueType;
        return $var;
    }

}
