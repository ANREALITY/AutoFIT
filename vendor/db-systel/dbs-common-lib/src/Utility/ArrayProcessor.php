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
        $arrayUniqueByRow = $this->arrayUniqueByRow($arrayForMakingUniqueByRow, $implodeSeparator);
        $arrayUniqueByMultipleIdentifiers = array_intersect_key($table, $arrayUniqueByRow);
        return $arrayUniqueByMultipleIdentifiers;
    }
    
    public function removeArrayColumns(array $table, array $columnNames, bool $isWhitelist = false)
    {
        foreach ($table as $rowKey => $row) {
            if (is_array($row)) {
                if ($isWhitelist) {
                    foreach ($row as $fieldName => $fieldValue) {
                        if (!in_array($fieldName, $columnNames)) {
                            unset($table[$rowKey][$fieldName]);
                        }
                    }
                } else {
                    foreach ($row as $fieldName => $fieldValue) {
                        if (in_array($fieldName, $columnNames)) {
                            unset($table[$rowKey][$fieldName]);
                        }
                    }
                }
            }
        }
        return $table;
    }
    
    public function arrayUniqueByRow(array $table = [], string $implodeSeparator)
    {
        $elementStrings = [];
        foreach ($table as $row) {
            // To avoid notices like "Array to string conversion".
            $elementPreparedForImplode = array_map(
                function ($field) {
                    $valueType = gettype($field);
                    $simpleTypes = ['boolean', 'integer', 'double', 'float', 'string', 'NULL'];
                    $field = in_array($valueType, $simpleTypes) ? $field : $valueType;
                    return $field;
                }, $row
                );
            $elementStrings[] = implode($implodeSeparator, $elementPreparedForImplode);
        }
        $elementStringsUnique = array_unique($elementStrings);
        $table = array_intersect_key($table, $elementStringsUnique);
        return $table;
    }
    
}
