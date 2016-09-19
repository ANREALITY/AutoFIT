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
     * Limitations:
     * Works correctly only for elementary values.
     * Doesn't work for objects (fatal error due to converting object to string);
     * notice (due to converting array to string) and not tested for arrays.
     *
     * @param array $array
     * @param string $identifier A value allowed as an array element's key.
     */
    protected function arrayUniqueBySingleIdentifier(array $array, string $identifier)
    {
        $arrayIds = array_keys($array);
        $identifierColumn = array_column($array, $identifier);
        $identifierColumnWithIds = array_combine($arrayIds, $identifierColumn);
        $identifierColumnUnique = array_unique($identifierColumnWithIds);

        $arrayUnique = array_intersect_key($array, $identifierColumnUnique);

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

    /**
     * Checks, whether the $array is valid.
     * It is valid, if it contains the given $identifier (prefixed by the $prefix)
     * and the element is not NULL or '' (empty string).
     * If a $condition given, it also has to be TRUE.
     * There also may be multiple prefix-identifier pairs.
     * In this case all prefix-identifier pairs need to be valid.
     *
     * @param array $array
     * @param callable $condition
     * @param string|array $identifier
     * @param string|array $prefix
     * @return boolean
     * @throws \InvalidArgumentException Will be thrown, if
     *  the $identifier and the $prefix are not both strnings or arrays OR
     *  they are array with different lengths.
     */
    public function validateArray(array $array, callable $condition = null, $identifier = null, $prefix = null)
    {
        $isValid =
        $this->validateArrayByCondition($array, $condition) &&
        $this->validateArrayByIdentifier($array, $identifier, $prefix)
        ;
        return $isValid;
    }
    
    /**
     * Checks, whether the $array is valid.
     * It is valid, if it contains the given $identifier (prefixed by the $prefix)
     * and the element is not NULL or '' (empty string).
     * There also may be multiple prefix-identifier pairs.
     * In this case all prefix-identifier pairs need to be valid.
     *
     * @param array $array
     * @param string|array $identifier
     * @param string|array $prefix
     * @return boolean
     * @throws \InvalidArgumentException Will be thrown, if
     *  the $identifier and the $prefix are not both strnings or arrays OR
     *  they are array with different lengths.
     */
    protected function validateArrayByIdentifier(array $array, $identifier = null, $prefix = null)
    {
        if (
            gettype($prefix) != gettype($identifier) &&
            ! ((is_array($prefix) && is_array($identifier)) && (count($identifier) == count($prefix)))
            ) {
                throw new \InvalidArgumentException('The arrays with identifiers and prefixes have to be strings or arrays of equal length.');
            }
            // Preventing creating empty objects.
            // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
            $valid = true;
            if (is_string($identifier)) {
                $completeIdentifier = $prefix . $identifier;
                $valid =
                isset($array[$completeIdentifier]) && ! (
                    $array[$completeIdentifier] === '' || $array[$completeIdentifier] === null
                    );
            } elseif (is_array($identifier)) {
                foreach ($identifier as $key => $partIdentifierValue) {
                    $completeIdentifier = $prefix[$key] . $partIdentifierValue;
                    $valid =
                    isset($array[$completeIdentifier]) && ! (
                        $array[$completeIdentifier] === '' || $array[$completeIdentifier] === null
                        )
                        ;
                    if (! $valid) {
                        break;
                    }
                }
            }
            return $valid;
    }
    
    /**
     * Checks, whether the $array is valid.
     * It is valid, if the given $condition is TRUE.
     *
     * @param array $array
     * @param callable $condition
     * @return boolean
     */
    protected function validateArrayByCondition(array $array, callable $condition = null)
    {
        $valid = true;
        if ($condition && ! $condition($array)) {
            $valid = false;
        }
        return $valid;
    }

}
