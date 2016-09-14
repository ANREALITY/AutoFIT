<?php
namespace Order\Mapper;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractDataObject;
use DbSystel\Utility\TableDataProcessor;

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

    /**
     * @var TableDataProcessor
     */
    protected $tableDataProcessor;

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

    /**
     * @return the $tableDataProcessor
     */
    public function getTableDataProcessor()
    {
        return $this->tableDataProcessor;
    }

    /**
     * @param TableDataProcessor $tableDataProcessor
     */
    public function setTableDataProcessor(TableDataProcessor $tableDataProcessor)
    {
        $this->tableDataProcessor = $tableDataProcessor;
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        // Resolves the case of abstract entities (like Endpoint or PhysicalConnection).
        // @todo Maybe $prototypeMap property instead of the $prototype property.
        $prototype = $prototype ?: $this->getPrototype();
        $prototypeClass = get_class($prototype);

        $uniqueResultSetArray = [];
        // For cases with an inverted relationship like
        // file_transfer_request.user_id->user.id to FileTransferRequest.User as parent->child.
        // In otherweise in such cases some of the relevant rows can be ignored.
        $identifierMakingUnique = $childIdentifier ?: $identifier;
        $prefixMakingUnique = $childPrefix ?: $prefix;
        if (is_string($prefixMakingUnique)) {
            $uniqueResultSetArray = $this->tableDataProcessor->arrayUniqueByIdentifier($resultSetArray, $prefixMakingUnique . $identifierMakingUnique);
        } elseif (is_array($identifierMakingUnique)) {
            $completeIdentifierMakingUnique = function ($prefixMakingUnique, $identifierMakingUnique) {
                $result = [];
                foreach ($prefixMakingUnique as $key => $value) {
                    $result[] = $prefixMakingUnique[$key] . $identifierMakingUnique[$key];
                }
                return $result;
            };
            $uniqueResultSetArray = $this->tableDataProcessor->arrayUniqueByIdentifier($resultSetArray, $completeIdentifierMakingUnique($prefixMakingUnique, $identifierMakingUnique));
        }

        $dataObjects = [];
        foreach ($uniqueResultSetArray as $row) {
            if (!$this->tableDataProcessor->validateArray($row, $dataObjectCondition, $identifier, $prefix)) {
                continue;
            }
            $prototypeForHydration = new $prototypeClass();
            $objectData = [];
            // @todo Maybe faster with array_map(...).
            foreach ($row as $columnAlias => $value) {
                $key = $columnAlias;
                if ($this->tableDataProcessor->isProperColumn($columnAlias, $prefix)) {
                    if (is_string($prefix)) {
                        $key = str_replace($prefix, '', $columnAlias);
                        $objectData[$key] = $value;
                    } elseif (is_array($prefix)) {
                        // @todo Replace this strange performance pest by str_replace($array, $string)!
                        foreach ($prefix as $currentPrefix) {
                            $key = str_replace($currentPrefix, '', $columnAlias);
                            $objectData[$key] = $value;
                        }
                    }
                }
            }
            if (! empty($objectData)) {
                if (! empty($parentPrefix . $parentIdentifier) && ! empty($row[$parentPrefix . $parentIdentifier])) {
                    $objectParentIndexIdentifier = $parentPrefix . $parentIdentifier;
                    $objectParentIndex = $row[$objectParentIndexIdentifier];
                    if ($isCollection) {
                        if (empty($dataObjects[$objectParentIndex])) {
                            $dataObjects[$objectParentIndex] = [];
                        }
                        $dataObjects[$objectParentIndex][] = $this->hydrator->hydrate($objectData, $prototypeForHydration);
                    } else {
                        $dataObjects[$objectParentIndex] = $this->hydrator->hydrate($objectData, $prototypeForHydration);
                    }
                } elseif (! empty($childPrefix . $childIdentifier) && ! empty($row[$childPrefix . $childIdentifier])) {
                    $objectParentIndexIdentifier = $childPrefix . $childIdentifier;
                    $objectParentIndex = $row[$objectParentIndexIdentifier];
                    if ($isCollection) {
                        if (empty($dataObjects[$objectParentIndex])) {
                            $dataObjects[$objectParentIndex] = [];
                        }
                        $dataObjects[$objectParentIndex][] = $this->hydrator->hydrate($objectData, $prototypeForHydration);
                    } else {
                        $dataObjects[$objectParentIndex] = $this->hydrator->hydrate($objectData, $prototypeForHydration);
                    }
                } else {
                    $dataObjects[] = $this->hydrator->hydrate($objectData, $prototypeForHydration);
                }
            }
            // sub-objects
        }
        return $dataObjects;
    }

    protected function appendSubDataObject(&$dataObject, $parentId, array $subDataObjects, $subDataObjectSetter,
        $identifierGetter)
    {
        // DANGEROUS!!!
        // Array key of a common element (created like myArray[] = new Element();)
        // can though equal to the $dataObject->getId()!!!!!
        if (array_key_exists($parentId, $subDataObjects)) {
            $dataObject->$subDataObjectSetter($subDataObjects[$dataObject->$identifierGetter()]);
        }
    }

}
