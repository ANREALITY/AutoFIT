<?php
namespace DbSystel\Utility;

class TableDataProcessor extends ArrayProcessor
{

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

}
