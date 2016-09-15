<?php
namespace DbSystel\Utility;

class TableDataProcessor extends ArrayProcessor
{

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
    public function validateRow(array $array, callable $condition = null, $identifier = null, $prefix = null)
    {
        $isValid =
            $this->validateRowByCondition($array, $condition) &&
            $this->validateRowByIdentifier($array, $identifier, $prefix)
        ;
        return $isValid;
    }

    /**
     * 
     * @param string $columnAlias
     * @param string|array $prefixes
     * @return boolean
     */
    public function validateColumnByPrefix(string $columnAlias, $prefixes)
    {
        $prefixIsValid = false;
        if (is_string($prefixes)) {
            if (! empty($prefixes) && strpos($columnAlias, $prefixes) === 0) {
                $prefixIsValid = true;
            }
        } elseif (is_array($prefixes)) {
            foreach ($prefixes as $prefix) {
                if (! empty($prefix) && strpos($columnAlias, $prefix) === 0) {
                    $prefixIsValid = true;
                    break;
                }
            }
        }
        return $prefixIsValid;
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
    protected function validateRowByIdentifier(array $array, $identifier = null, $prefix = null)
    {
        if (
            gettype($prefix) != gettype($identifier) &&
            ! ((is_array($prefix) && is_array($identifier)) && (count($identifier) == count($prefix)))
        ) {
            throw new \InvalidArgumentException('The arrays with identifiers and prefixes have to be strings or arrays of equal length.');
        }
        // Preventing creating empty objects.
        // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
        $identifierOk = true;
        if (is_string($identifier)) {
            $completeIdentifier = $prefix . $identifier;
            $identifierOk =
            isset($array[$completeIdentifier]) && ! (
                $array[$completeIdentifier] === '' || $array[$completeIdentifier] === null
            );
        } elseif (is_array($identifier)) {
            foreach ($identifier as $key => $partIdentifierValue) {
                $completeIdentifier = $prefix[$key] . $partIdentifierValue;
                $identifierOk =
                isset($array[$completeIdentifier]) && ! (
                    $array[$completeIdentifier] === '' || $array[$completeIdentifier] === null
                    )
                    ;
                if (! $identifierOk) {
                    break;
                }
            }
        }
        return $identifierOk;
    }

    /**
     * Checks, whether the $array is valid.
     * It is valid, if the given $condition is TRUE.
     *
     * @param array $array
     * @param callable $condition
     * @return boolean
     */
    protected function validateRowByCondition(array $array, callable $condition = null)
    {
        $conditionOk = true;
        if ($condition && ! $condition($array)) {
            $conditionOk = false;
        }
        return $conditionOk;
    }

}
