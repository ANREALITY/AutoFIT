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
            $this->validateArrayByCondition($array, $condition) &&
            $this->validateArrayByIdentifier($array, $identifier, $prefix)
        ;
        return $isValid;
    }

    /**
     * 
     * @param string $string
     * @param string|array $prefix
     * @return boolean
     */
    public function validateStringByPrefix(string $string, $prefix)
    {
        $valid = false;
        if (is_string($prefix)) {
            if (! empty($prefix) && strpos($string, $prefix) === 0) {
                $valid = true;
            }
        } elseif (is_array($prefix)) {
            foreach ($prefix as $partPrefix) {
                if (strpos($string, $partPrefix) === 0) {
                    $valid = true;
                    break;
                }
            }
        }
        return $valid;
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
