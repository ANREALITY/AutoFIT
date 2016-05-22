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

    public function createDataObjects(
        array $resultSetArray,
        string $parentIdentifier = null, string $parentPrefix = null,
        string $identifier = null, string $prefix = null,
        $prototype = null
    ) {
        // Resolves the case of abstract entities (like Endpoint or PhysicalConnection).
        // @todo Maybe $prototyMap property instead of the $prototype property.
        $prototype = $prototype ?: $this->getPrototype();

        if (!$prototype) {
            $breakpoint = null;
        }
        
        $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $prefix . $identifier);
        // $processedIdentifiers = [];
        $dataObjects = [];
        foreach ($uniqueResultSetArray as $row) {
            $objectData = [];
            foreach ($row as $columnAlias => $value) {
                $key = $columnAlias;
                if (!empty($prefix) && strpos($columnAlias, $prefix) === 0) {
                    $key = str_replace($prefix, '', $columnAlias);
                }
                // @todo Avoid creating empty objects!!!
                // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
                // Maybe solve it with a !empty($identifier) check.
                // @todo Extend the logi for handling of collections (like Notification)
                $objectData[$key] = $value;
            }
            if (!empty($objectData)) {
                if (!empty($parentPrefix . $parentIdentifier) && !empty($row[$parentPrefix . $parentIdentifier])) {
                    $dataObjects[$row[$parentPrefix . $parentIdentifier]] = $this->hydrator->hydrate($objectData, $prototype);
                } else {
                    $dataObjects[] = $this->hydrator->hydrate($objectData, $prototype);
                }
            }
            // sub-objects
        }
        return $dataObjects;
    }

    protected function arrayUniqueByIdentifier(array $array, string $identifier)
    {
        $ids = array_column($array, $identifier);
        $ids = array_unique($ids);
        $array = array_filter($array, function ($key, $value) use ($ids) {
            return in_array($value, array_keys($ids));
        }, ARRAY_FILTER_USE_BOTH);
        return $array;
    }

    protected function appendSubDataObject(&$dataObject, $parentId, array $subDataObjects, $subDataObjectSetter, 
        $identifierGetter)
    {
        if (array_key_exists($parentId, $subDataObjects)) {
            $dataObject->$subDataObjectSetter($subDataObjects[$dataObject->$identifierGetter()]);
        }
    }

}
