<?php
namespace DbSystel\Utility;

class ArrayProcessor
{

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

    public function arrayUniqueByIdentifier(array $array, $identifier)
    {
        if (is_string($identifier)) {
            // Get the grouping column array unique.
            $ids = array_column($array, $identifier);
            $ids = array_unique($ids);
            // Filter the original array by the keys of the grouping column array.
            $array = array_filter($array,
                function ($key, $value) use($ids) {
                    return in_array($value, array_keys($ids));
                }, ARRAY_FILTER_USE_BOTH);
        } elseif (is_array($identifier)) {
            $array = $this->arrayUniqueByMultipleIdentifiers($array, $identifier, '|||');
        }
        return $array;
    }

    public function arrayUniqueByMultipleIdentifiers(array $table, array $identifiers, string $implodeSeparator = null)
    {
        $arrayForMakingUniqueByRow = $this->removeArrayColumns($table, $identifiers, true);
        $arrayUniqueBySubArray = $this->arrayUniqueBySubArray($arrayForMakingUniqueByRow, $implodeSeparator);
        $arrayUniqueByMultipleIdentifiers = array_intersect_key($table, $arrayUniqueBySubArray);
        return $arrayUniqueByMultipleIdentifiers;
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
     * @param string $implodeSeparator
     */
    public function arrayUniqueBySubArray(array $table = [], string $implodeSeparator = null)
    {
        $elementStrings = $this->stringifySubArrays($table, $implodeSeparator);
        $elementStringsUnique = array_unique($elementStrings);
        $table = array_intersect_key($table, $elementStringsUnique);
        return $table;
    }

    /**
     * Makes from every sub-array a string from its elements
     * (flattened and separated by the $implodeSeparator)
     * and returns an array of these "strigified" sub-arrays.
     * The indexes of the stringified sub-arrays remain the same
     *  as the indexes of the original sub-array elements.
     *
     * @see ArrayProcessor#flattenArray(...)
     * @see ArrayProcessor#stringifyArray(...)
     *
     * @param array $array
     * @param string $implodeSeparator
     */
    public function stringifySubArrays(array $array, string $implodeSeparator = null) {
        $elementStrings = [];
        foreach ($array as $key => $subArray) {
            $elementStrings[$key] = $this->stringifyArray($subArray, $implodeSeparator);
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
