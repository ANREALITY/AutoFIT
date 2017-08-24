<?php
namespace Order\Mapper;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractDataObject;
use DbSystel\Utility\TableDataProcessor;
use DbSystel\Utility\StringUtility;

class AbstractMapper
{

    /**
     * @var integer
     */
    const DEFAULT_ITEM_COUNT_PER_PAGE = 10;

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
     * @var integer
     */
    protected $itemCountPerPage;

    /**
     * @var TableDataProcessor
     */
    protected $tableDataProcessor;

    /**
     * @var StringUtility
     */
    protected $stringUtility;

    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        AbstractDataObject $prototype = null,
        int $itemCountPerPage = null
    ) {
        $this->setDbAdapter($dbAdapter);
        $this->setHydrator($hydrator);
        if ($prototype) {
            $this->setPrototype($prototype);
        }
        $this->itemCountPerPage = $itemCountPerPage ?: self::DEFAULT_ITEM_COUNT_PER_PAGE;
    }

    /**
     *
     * @return AdapterInterface $dbAdapter
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
     * @return HydratorInterface $hydrator
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
     * @return AbstractDataObject clone of the $prototype
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
     * @return TableDataProcessor $tableDataProcessor
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

    /**
     * @param StringUtility $stringUtility
     */
    public function setStringUtility(StringUtility $stringUtility)
    {
        $this->stringUtility = $stringUtility;
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $uniqueResultSetArray = $this->generateUniqueResultSetArray($identifier, $prefix, $childIdentifier, $childPrefix, $resultSetArray);
        $dataObjects = $this->buildDataObjects($uniqueResultSetArray,
            $parentIdentifier, $parentPrefix, $identifier, $prefix, $childIdentifier, $childPrefix,
            $prototype, $dataObjectCondition, $isCollection
        );

        return $dataObjects;
    }

    protected function generateUniqueResultSetArray($identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, array $resultSetArray = [])
    {
        $uniqueResultSetArray = [];
        // For cases with an inverted relationship like
        // file_transfer_request.user_id->user.id to FileTransferRequest.User as parent->child.
        // Otherwise in such cases some of the relevant rows can be ignored.
        $identifierMakingUnique = $childIdentifier ?: $identifier;
        $prefixMakingUnique = $childPrefix ?: $prefix;
        if (is_string($prefixMakingUnique)) {
            $uniqueResultSetArray = $this->tableDataProcessor->tableUniqueByIdentifier(
                $resultSetArray, $prefixMakingUnique . $identifierMakingUnique
            );
        } elseif (is_array($identifierMakingUnique)) {
            $identifiersMakingUnique = $this->tableDataProcessor->mergeArraysElementsToStrings(
                null, null, $prefixMakingUnique, $identifierMakingUnique
            );
            $uniqueResultSetArray = $this->tableDataProcessor->tableUniqueByIdentifier(
                $resultSetArray, $identifiersMakingUnique
            );
        }
        return $uniqueResultSetArray;
    }

    /**
     * Takes a table (two-dimensional array) and
     * creates objects of type of the $prototype from it.
     * It's assumed, that the rows of the $uniqueResultSetArray are unique.
     * That means the table cannot contain identical rows.
     * Two rows are identical, if 
     * That means the result DataObject set cannot contain identical objects.
     *
     * @param array $uniqueResultSetArray
     * @param string|array $parentIdentifier
     * @param string|array $parentPrefix
     * @param string|array $identifier
     * @param string|array $prefix
     * @param string|array $childIdentifier
     * @param string|array $childPrefix
     * @param object $prototype
     * @param callable $dataObjectCondition
     * @param bool $isCollection
     * @return AbstractDataObject[]
     */
    protected function buildDataObjects(array $uniqueResultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        // Resolves the case of abstract entities (like Endpoint or PhysicalConnection).
        // @todo Maybe $prototypeMap property instead of the $prototype property.
        $prototype = $prototype ?: $this->getPrototype();
        $prototypeClass = get_class($prototype);
        $dataObjects = [];
        foreach ($uniqueResultSetArray as $row) {
            if (!$this->tableDataProcessor->validateArray($row, $dataObjectCondition, $identifier, $prefix)) {
                continue;
            }
            $prototypeForHydration = new $prototypeClass();
            $objectData = $this->tableDataProcessor->extractElementsWithKeyPrefixedByString($row, $prefix);
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
