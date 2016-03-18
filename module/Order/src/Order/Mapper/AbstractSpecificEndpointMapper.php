<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractSpecificEndpoint;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

abstract class AbstractSpecificEndpointMapper implements SpecificEndpointMapperInterface
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
     * @var AbstractSpecificEndpoint
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, AbstractSpecificEndpoint $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id
     *
     * @return AbstractSpecificEndpoint
     * @throws \InvalidArgumentException
     */
    abstract public function find($id);

    /**
     *
     * @return array|AbstractSpecificEndpoint[]
     */
    abstract public function findAll(array $criteria = []);

    /**
     *
     * @param AbstractSpecificEndpoint $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    abstract public function save(AbstractSpecificEndpoint $dataObject);
}
