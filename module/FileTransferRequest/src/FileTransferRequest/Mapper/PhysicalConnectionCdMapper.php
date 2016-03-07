<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

abstract class PhysicalConnectionCdMapper implements PhysicalConnectionCdMapperInterface
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
     * @var PhysicalConnectionCd
     */
    protected $prototype;

    /**
     *
     * @var PhysicalConnectionMapper
     */
    protected $physicalConnectionMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, PhysicalConnectionCd $prototype, PhysicalConnectionMapper $physicalConnectionMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->physicalConnectionMapper = $physicalConnectionMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return PhysicalConnectionCd
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection_cd');
         * $select->where(array(
         * 'id = ?' => $id
         * ));
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("PhysicalConnectionCd with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|PhysicalConnectionCd[]
     */
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection_cd');
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
         *
         * return $resultSet->initialize($result);
         * }
         *
         * return array();
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param PhysicalConnectionCd $dataObject
     *
     * @return PhysicalConnectionCd
     * @throws \Exception
     */
    public function save(PhysicalConnectionCd $dataObject)
    {
        $physicalConnection = $this->physicalConnectionMapper->save($dataObject);
        $dataObject->setPhysicalConnection($physicalConnection);

        $physicalConnectionCdData = $this->hydrator->extract($dataObject);
        $physicalConnectionFtgwData['physical_connection_id'] = $physicalConnection->getId();

        if ($dataObject->getId()) {
            $action = new Update('physical_connection_cd');
            $action->set($physicalConnectionCdData);
            $action->where(array(
                'physical_connection_id = ?' => $physicalConnection->getId()
            ));
        } else {
            $action = new Insert('physical_connection_cd');
            $action->values($physicalConnectionCdData);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
            }

            return $dataObject;
        }

        throw new \Exception('Database error in ' . __METHOD__);
    }
}
