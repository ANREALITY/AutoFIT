<?php
namespace DbSystel\Utility;

class TableDataProcessor extends ArrayProcessor
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

}
