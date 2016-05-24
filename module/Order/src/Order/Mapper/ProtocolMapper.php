<?php
namespace Order\Mapper;

use DbSystel\DataObject\Protocol;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ProtocolMapper extends AbstractMapper implements ProtocolMapperInterface
{

    /**
     *
     * @var Protocol
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Protocol $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $name
     *
     * @return Protocol
     * @throws \InvalidArgumentException
     */
    public function findOne($name)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Protocol[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param Protocol $dataObject
     *
     * @return Protocol
     * @throws \Exception
     */
    public function save(Protocol $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
