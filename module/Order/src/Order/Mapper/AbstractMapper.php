<?php
namespace Order\Mapper;

use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractDataObject;
use DbSystel\Utility\TableDataProcessor;
use DbSystel\Utility\StringUtility;
use InvalidArgumentException;
use ReflectionClass;

class AbstractMapper
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = AbstractDataObject::class;
    /** @var integer */
    const DEFAULT_ITEM_COUNT_PER_PAGE = 10;
    /** @var integer */
    const DEFAULT_QUERY_LIMIT = 25;

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

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator = null,
        AbstractDataObject $prototype = null,
        int $itemCountPerPage = null,
        EntityManager $entityManager
    ) {
        $this->setDbAdapter($dbAdapter);
        if ($hydrator && $hydrator instanceof HydratorInterface) {
            $this->setHydrator($hydrator);
        }
        if ($prototype) {
            $this->setPrototype($prototype);
        }
        $this->itemCountPerPage = $itemCountPerPage ?: self::DEFAULT_ITEM_COUNT_PER_PAGE;
        $this->entityManager = $entityManager;
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

    /**
     * @param $id
     * @return AbstractDataObject
     * @throws InvalidArgumentException
     */
    public function findOne($id)
    {
        $repository = $this->entityManager->getRepository(static::ENTITY_TYPE);
        $entity = $repository->find($id);
        if (! $entity) {
            $reflection = new ReflectionClass(static::ENTITY_TYPE);
            $entityClassName = $reflection->getShortName();
            throw new InvalidArgumentException($entityClassName . " with given ID:{$id} not found.");
        }
        /** @var AbstractDataObject $entity */
        return $entity;
    }

}
