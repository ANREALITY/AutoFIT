<?php
namespace Order\Mapper;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractDataObject;

class AbstractMapper
{

    /**
     *
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     *
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     *
     * @var AbstractDataObject
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator,
        AbstractDataObject $prototype = null)
    {
        $this->setDbAdapter($dbAdapter);
        $this->setHydrator($hydrator);
        if ($prototype) {
            $this->setPrototype($prototype);
        }
    }

    /**
     *
     * @return the $dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }

    /**
     *
     * @param AdapterInterface $dbAdapter
     */
    public function setDbAdapter(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     *
     * @return the $hydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     *
     * @param HydratorInterface $hydrator
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     *
     * @return the clone of the $prototype
     */
    public function getPrototype()
    {
        return $this->prototype ? clone $this->prototype : null;
    }

    /**
     *
     * @param AbstractDataObject $prototype
     */
    public function setPrototype(AbstractDataObject $prototype)
    {
        $this->prototype = $prototype;
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        // Resolves the case of abstract entities (like Endpoint or PhysicalConnection).
        // @todo Maybe $prototyMap property instead of the $prototype property.
        $prototype = $prototype ?: $this->getPrototype();
        $prototypeClass = get_class($prototype);

        $uniqueResultSetArray = [];
        // For cases with an inverted relationship like
        // file_transfer_request.user_id->user.id to FileTransferRequest.User as parent->child.
        // In otherweise in such cases some of the relevant rows can be ignored.
        $identifierMakingUnique = $childIdentifier ?: $identifier;
        $prefixMakingUnique = $childPrefix ?: $prefix;
        if (is_string($prefixMakingUnique)) {
            $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $prefixMakingUnique . $identifierMakingUnique);
        } elseif (is_array($identifierMakingUnique)) {
            $completeIdentifierMakingUnique = function ($prefixMakingUnique, $identifierMakingUnique) {
                $result = [];
                foreach ($prefixMakingUnique as $key => $value) {
                    $result[] = $prefixMakingUnique[$key] . $identifierMakingUnique[$key];
                }
                return $result;
            };
            $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $completeIdentifierMakingUnique($prefixMakingUnique, $identifierMakingUnique));
        }

        $dataObjects = [];
        foreach ($uniqueResultSetArray as $row) {
            // @todo Avoid creating empty objects!!!
            // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
            // Maybe solve it with a !empty($identifier) check.
            if ($dataObjectCondition) {
                if (! $dataObjectCondition($row)) {
                    continue;
                } else {
                    $breakpoint = null;
                }
            }
            $prototype = new $prototypeClass();
            $objectData = [];
            foreach ($row as $columnAlias => $value) {
                $key = $columnAlias;
                if ($this->isProperColumn($columnAlias, $prefix)) {
                    if (is_string($prefix)) {
                        $key = str_replace($prefix, '', $columnAlias);
                        $objectData[$key] = $value;
                    } elseif (is_array($prefix)) {
                        foreach ($prefix as $currentPrefix) {
                            $key = str_replace($currentPrefix, '', $columnAlias);
                            $objectData[$key] = $value;
                        }
                    }
                }
            }
            if (! empty($objectData)) {
                if (! empty($parentPrefix . $parentIdentifier) && ! empty($row[$parentPrefix . $parentIdentifier])) {
                    if ($isCollection) {
                        $test = $row[$parentPrefix . $parentIdentifier];
                        if (empty($dataObjects[$row[$parentPrefix . $parentIdentifier]])) {
                            $dataObjects[$row[$parentPrefix . $parentIdentifier]] = [];
                        }
                        $dataObjects[$row[$parentPrefix . $parentIdentifier]][] = $this->hydrator->hydrate($objectData, $prototype);
                    } else {
                        $dataObjects[$row[$parentPrefix . $parentIdentifier]] = $this->hydrator->hydrate($objectData, $prototype);
                    }
                } elseif (! empty($childPrefix . $childIdentifier) && ! empty($row[$childPrefix . $childIdentifier])) {
                    if ($isCollection) {
                        $test = $row[$childPrefix . $childIdentifier];
                        if (empty($dataObjects[$row[$childPrefix . $childIdentifier]])) {
                            $dataObjects[$row[$childPrefix . $childIdentifier]] = [];
                        }
                        $dataObjects[$row[$childPrefix . $childIdentifier]][] = $this->hydrator->hydrate($objectData, $prototype);
                    } else {
                        $dataObjects[$row[$childPrefix . $childIdentifier]] = $this->hydrator->hydrate($objectData, $prototype);
                    }
                } else {
                    $dataObjects[] = $this->hydrator->hydrate($objectData, $prototype);
                }
            }
            $breakpoint = null;
            // sub-objects
        }
        return $dataObjects;
    }

    protected function isProperColumn(string $columnAlias, $prefixes)
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

    protected function arrayUniqueByIdentifier(array $array, $identifier)
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

    protected function arrayUniqueByMultipleIdentifiers(array $table, array $identifiers, string $implodeSeparator = null)
    {
        $arrayForMakingUniqueByRow = $this->removeArrayColumns($table, $identifiers, true);
        $arrayUniqueByRow = $this->arrayUniqueByRow($arrayForMakingUniqueByRow, $implodeSeparator);
        $arrayUniqueByMultipleIdentifiers = array_intersect_key($table, $arrayUniqueByRow);
        return $arrayUniqueByMultipleIdentifiers;
    }
    
    protected function removeArrayColumns(array $table, array $columnNames, bool $isWhitelist = false)
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
    
    protected function arrayUniqueByRow(array $table = [], string $implodeSeparator)
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

    protected function appendSubDataObject(&$dataObject, $parentId, array $subDataObjects, $subDataObjectSetter,
        $identifierGetter)
    {
        // DANGEROUS!!!
        // Array key of a common element (created like myArray[] = new Element();)
        // can though quals to the $dataObject->getId()!!!!!
        if (array_key_exists($parentId, $subDataObjects)) {
            $dataObject->$subDataObjectSetter($subDataObjects[$dataObject->$identifierGetter()]);
        }
    }

}
