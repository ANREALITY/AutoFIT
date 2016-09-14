<?php
namespace DbSystel\Utility;

class TableDataProcessor extends ArrayProcessor
{

    /**
     * Checks, whether the $row of a table (two-dimensional array) is "proper".
     * It is proper, if it contains the given $identifier (prefixed by the $prefix)
     * and the element is not NULL or '' (empty string).
     * If a $condition given, it also has to be TRUE.
     * There also may be multiple prefix-identifier pairs.
     * In this case all prefix-identifier pairs need to be "proper".
     *
     * @param array $row
     * @param callable $condition
     * @param unknown $identifier
     * @param unknown $prefix
     * @return boolean
     * @throws \InvalidArgumentException Will be thrown, if
     *  the $identifier and the $prefix are not both strnings or arrays OR
     *  they are array with different lengths.
     *  
     */
    public function isProperRow(array $row, callable $condition = null, $identifier = null, $prefix = null)
    {
        if (
            gettype($prefix) != gettype($identifier) &&
            ! ((is_array($prefix) && is_array($identifier)) && (count($identifier) == count($prefix)))
        ) {
            throw new \InvalidArgumentException('The arrays with identifiers and prefixes have to be strings or arrays of equal length.');
        }
        $isProper = false;
        $conditionOk = true;
        if ($condition && ! $condition($row)) {
            $conditionOk = false;
        }
        // Preventing creating empty objects.
        // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
        $identifierOk = true;
        if (is_string($identifier)) {
            $completeIdentifier = $prefix . $identifier;
            $identifierOk =
                isset($row[$completeIdentifier]) && ! (
                    $row[$completeIdentifier] === '' || $row[$completeIdentifier] === null
                )
            ;
        } elseif (is_array($identifier)) {
            foreach ($identifier as $key => $partIdentifierValue) {
                $completeIdentifier = $prefix[$key] . $partIdentifierValue;
                $identifierOk =
                    isset($row[$completeIdentifier]) && ! (
                        $row[$completeIdentifier] === '' || $row[$completeIdentifier] === null
                    )
                    ;
                if (! $identifierOk) {
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

}
