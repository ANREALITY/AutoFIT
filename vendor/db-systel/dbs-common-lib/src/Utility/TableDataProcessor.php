<?php
namespace DbSystel\Utility;

/**
 * This class provides methods to processes the data of tables / two-dimensional arrays.
 */
class TableDataProcessor extends ArrayProcessor
{

    /**
     * Returns the input table with only unique rows.
     * To determinate the uniqueness of the rows
     * following logic is applied:
     * A row $foo is identical to another row $bar,
     * if the value(-s) of the $identifier element(-s) in $foo
     * equals to the value(-s) of the correspondent element(-s) in $bar.
     *
     * @param array $table
     * @param string|array $identifier The identifying key or an array of such keys.
     * @return array
     */
    public function tableUniqueByIdentifier(array $table, $identifier)
    {
        if (is_string($identifier)) {
            $tableUnique = $this->tableUniqueBySingleIdentifier($table, $identifier);
        } elseif (is_array($identifier)) {
            $tableUnique = $this->tableUniqueByMultipleIdentifiers($table, $identifier);
        }
        return $tableUnique;
    }

    /**
     * Returns the input table with only unique rows.
     * To determinate the uniqueness of the rows
     * following logic is applied:
     * A row $foo is identical to another row $bar,
     * if the value of the $identifier element in $foo
     * equals to the value of the correspondent element in $bar.
     *
     * Limitations:
     * Works correctly only for elementary values.
     * Doesn't work for objects (fatal error due to converting object to string);
     * notice (due to converting array to string) and not tested for arrays.
     *
     * @param array $table
     * @param string $identifier The identifying key.
     * @return array
     */
    protected function tableUniqueBySingleIdentifier(array $table, string $identifier)
    {
        $tableIds = array_keys($table);
        $identifierColumn = array_column($table, $identifier);
        $identifierColumnWithIds = array_combine($tableIds, $identifierColumn);
        $identifierColumnUnique = array_unique($identifierColumnWithIds);
    
        $tableUnique = array_intersect_key($table, $identifierColumnUnique);
    
        return $tableUnique;
    }

    /**
     * Returns the input table with only unique rows.
     * To determinate the uniqueness of the rows
     * following logic is applied:
     * A row $foo is identical to another row $bar,
     * if the values of the $identifier elements in $foo
     * equals to the values of the correspondent elements in $bar.
     *
     * @param array $table
     * @param array $identifier An array of identifying keys.
     * @return array
     */
    protected function tableUniqueByMultipleIdentifiers(array $table, array $identifiers)
    {
        $arrayForMakingUniqueByRow = $this->removeColumns($table, $identifiers, true);
        $tableUniqueBySubArray = $this->tableUniqueByRow($arrayForMakingUniqueByRow);
        $tableUnique = array_intersect_key($table, $tableUniqueBySubArray);
        return $tableUnique;
    }

    /**
     * Removes some of the table's columns
     * (means the second-level elements with the specified keys).
     * If $isWhitelist is TRUE, all $columnNames are removed.
     * Else these are on the "whitelist" and the other are removed.
     *
     * @param array $table
     * @param array $columnNames
     * @param bool $isWhitelist
     * @return array
     */
    public function removeColumns(array $table, array $columnNames, bool $isWhitelist = false)
    {
        $tableKeys = array_keys($table);
        $firstRowKey = $tableKeys[0];
        $firstRow = $table[$firstRowKey];
        $allColumnNames = array_keys($firstRow);
        $columns = [];
        $i = 0;
        $arrayMapInputVarNames = [];
        foreach ($allColumnNames as $columnName) {
            $remain =
                ($isWhitelist && in_array($columnName, $columnNames)) ||
                (! $isWhitelist && ! in_array($columnName, $columnNames))
            ;
            if($remain) {
                $varName = 'column' . $i++;
                $$varName = $columns[$columnName] = array_column($table, $columnName);
                $arrayMapInputVarNames[] = '$' . $varName;
            }
        }
        $arrayMapInputString = implode(', ', $arrayMapInputVarNames);
        eval('$rows = array_map(null, ' . $arrayMapInputString . ');');
        foreach ($rows as $index => $row) {
            $rows[$index] = array_combine(array_keys($columns), array_values($row));
        }
        $table = array_combine(array_keys($table), $rows);
        return $table;
    }

    /**
     * Extracts the unique rows from the input $table.
     *
     * For uniqueness check the rows get "stringified" first.
     * The IDs of the unique result strings are then the IDs of the unique rows.
     *
     * @see TableDataProcessor#stringifyRows(...)
     * @param array $table
     * @return array
     */
    public function tableUniqueByRow(array $table = [])
    {
        $stringifiedRows = $this->stringifyRows($table, uniqid());
        $stringifiedRowsUnique = array_unique($stringifiedRows);
        $table = array_intersect_key($table, $stringifiedRowsUnique);
        return $table;
    }
    
    /**
     * Makes from every row a string from its elements
     * (flattened and separated by the $separator)
     * and returns an array of these "strigified" rows.
     * The indexes of the stringified rows remain the same
     *  as the indexes of the original talbe's rows.
     *
     * @see ArrayProcessor#flattenArray(...)
     * @see ArrayProcessor#stringifyArray(...)
     * @param array $table
     * @param string $separator
     * @return array
     */
    public function stringifyRows(array $table, string $separator = null) {
        $strigifiedRows = [];
        foreach ($table as $key => $row) {
            $strigifiedRows[$key] = $this->stringifyArray($row, $separator);
        }
        return $strigifiedRows;
    }

}
