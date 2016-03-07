<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\PhysicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class PhysicalConnectionMapper implements PhysicalConnectionMapperInterface
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
     * @var PhysicalConnection
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, PhysicalConnection $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id
     *
     * @return PhysicalConnection
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection');
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
         * throw new \InvalidArgumentException("PhysicalConnection with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|PhysicalConnection[]
     */
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('physical_connection');
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
     * @param PhysicalConnection $dataObject
     *
     * @return PhysicalConnection
     * @throws \Exception
     */
    public function save(PhysicalConnection $dataObject)
    {
        $physicalConnectionData = $this->hydrator->extract($dataObject);
        unset($physicalConnectionData['id']);

        if ($dataObject->getId()) {
            $action = new Update('physical_connection');
            $action->set($physicalConnectionData);
            $action->where(array(
                'id = ?' => $dataObject->getId()
            ));
        } else {
            $action = new Insert('physical_connection');
            $action->values($physicalConnectionData);
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
