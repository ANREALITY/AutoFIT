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

        if (! $prototype) {
            $breakpoint = null;
        }

        $uniqueResultSetArray = [];
        if (is_string($prefix)) {
            $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $prefix . $identifier);
        } elseif (is_array($prefix)) {
            $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $prefix[0] . $identifier[0]);
        }

        $dataObjects = [];
        foreach ($uniqueResultSetArray as $row) {

            if ($dataObjectCondition) {
                if (! $dataObjectCondition($row)) {
                    continue;
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
                // @todo Avoid creating empty objects!!!
                // Example: LogicalConnection->(EndToEndPhysicalConnnection||(EndToMiddlePhysicalConnnection&&MiddleToEndPhysicalConnnection))
                // Maybe solve it with a !empty($identifier) check.
                // @todo Extend the logi for handling of collections (like Notification)
            }
            if (! empty($objectData)) {
                if (! empty($parentPrefix . $parentIdentifier) && ! empty($row[$parentPrefix . $parentIdentifier])) {
                    if ($isCollection) {
                        if (empty($dataObjects[$row[$parentPrefix . $parentIdentifier]])) {
                            $dataObjects[$row[$parentPrefix . $parentIdentifier]] = [];
                        }
                        $dataObjects[$row[$parentPrefix . $parentIdentifier]][] = $this->hydrator->hydrate($objectData, $prototype);
                    } else {
                        $dataObjects[$row[$parentPrefix . $parentIdentifier]] = $this->hydrator->hydrate($objectData, $prototype);
                    }
                } elseif (! empty($childPrefix . $childIdentifier) && ! empty($row[$childPrefix . $childIdentifier])) {
                    if ($isCollection) {
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

    protected function arrayUniqueByIdentifier(array $array, string $identifier)
    {
        $ids = array_column($array, $identifier);
        $ids = array_unique($ids);
        $array = array_filter($array,
            function ($key, $value) use($ids) {
                return in_array($value, array_keys($ids));
            }, ARRAY_FILTER_USE_BOTH);
        return $array;
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
