<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractSpecificPhysicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

abstract class AbstractSpecificPhysicalConnectionMapper implements SpecificPhysicalConnectionMapperInterface
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
     * @var AbstractSpecificPhysicalConnection
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, AbstractSpecificPhysicalConnection $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id
     *
     * @return AbstractSpecificPhysicalConnection
     * @throws \InvalidArgumentException
     */
    abstract public function find($id);

    /**
     *
     * @return array|AbstractSpecificPhysicalConnection[]
     */
    abstract public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractSpecificPhysicalConnection $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    abstract public function save(AbstractSpecificPhysicalConnection $dataObject);
}
