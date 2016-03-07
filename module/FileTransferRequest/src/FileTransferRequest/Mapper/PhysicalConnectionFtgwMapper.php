<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnectionFtgw;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class PhysicalConnectionFtgwMapper implements PhysicalConnectionFtgwMapperInterface
{

    /**
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     *
     * @var PhysicalConnectionFtgw
     */
    protected $prototype;

    /**
     *
     * @var PhysicalConnectionMapper
     */
    protected $physicalConnectionMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, PhysicalConnectionFtgw $prototype, PhysicalConnectionMapper $physicalConnectionMapper)
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
     * @return PhysicalConnectionFtgw
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection_ftgw');
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
         * throw new \InvalidArgumentException("PhysicalConnectionFtgw with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|PhysicalConnectionFtgw[]
     */
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection_ftgw');
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
     * @param PhysicalConnectionFtgw $dataObject
     *
     * @return PhysicalConnectionFtgw
     * @throws \Exception
     */
    public function save(PhysicalConnectionFtgw $dataObject)
    {
        $physicalConnection = $this->physicalConnectionMapper->save($dataObject);
        $dataObject->setEndpointId($physicalConnection);

        $physicalConnectionFtgwData = $this->hydrator->extract($dataObject);
        $physicalConnectionFtgwData['physical_connection_id'] = $physicalConnection->getId();

        if ($dataObject->getId()) {
            $action = new Update('physical_connection_ftgw');
            $action->set($physicalConnectionFtgwData);
            $action->where(array(
                'physical_connection_id = ?' => $dataObject->getId()
            ));
        } else {
            $action = new Insert('physical_connection_ftgw');
            $action->values($physicalConnectionFtgwData);
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
