<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\PhysicalConnectionCd;

class PhysicalConnectionCdMapper extends AbstractPhysicalConnectionMapper
{

    /**
     * 
     * {@inheritDoc}
     * @see \Order\Mapper\AbstractPhysicalConnectionMapper::find()
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
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
         * throw new \InvalidArgumentException("LogicalConnection with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|AbstractPhysicalConnection[]
     */
    public function findAll(array $criteria = [])
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
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
         * return [];
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param PhysicalConnectionCd $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject)
    {
        $dataObject = parent::save($dataObject);

        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['secure_plus'] = $dataObject->getSecurePlus();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['physical_connection_id'] = $dataObject->getId();

        $action = new Insert('physical_connection_cd');
        $action->values($data);

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
