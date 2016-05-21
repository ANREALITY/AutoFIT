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

    protected $prefix;

    protected $identifier;

    /**
     *
     * @var AbstractDataObject
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator,
        AbstractDataObject $prototype = null, string $prefix = null, string $identifier = null)
    {
        $this->setDbAdapter($dbAdapter);
        $this->setHydrator($hydrator);
        if ($prototype) {
            $this->setPrototype($prototype);
        }
        $this->prefix = $prefix;
        $this->identifier = $identifier;
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
        return clone $this->prototype;
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
        string $parentIdentifierKey = null, string $parentIdentifierValue = null,
        string $identifier = null, array $map = []
    ) {
        $uniqueResultSetArray = $this->arrayUniqueByIdentifier($resultSetArray, $this->prefix . $this->identifier);
        $dataObjects = [];
        $identifier = $identifier ?: $this->prefix . $this->identifier;
        foreach ($resultSetArray as $row) {
            $objectData = [];
            foreach ($row as $columnAlias => $value) {
                if (strpos($columnAlias, $this->prefix) === 0) {
                    $objectData[str_replace($this->prefix, '', $columnAlias)] = $value;
                }
            }
            if (!empty($objectData)) {
                $dataObjects[] = $this->hydrator->hydrate($objectData, $this->getPrototype());
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

}
