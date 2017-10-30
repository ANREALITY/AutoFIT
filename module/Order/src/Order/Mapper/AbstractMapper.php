<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractDataObject;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;
use ReflectionClass;
use Zend\Db\Adapter\AdapterInterface;

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
     * @var integer
     */
    protected $itemCountPerPage;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(
        AdapterInterface $dbAdapter,
        EntityManager $entityManager
    ) {
        $this->setDbAdapter($dbAdapter);
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
     * @param int $itemCountPerPage
     */
    public function setItemCountPerPage(int $itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;
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
