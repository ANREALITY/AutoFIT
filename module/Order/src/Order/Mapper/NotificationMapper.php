<?php
namespace Order\Mapper;

use DbSystel\DataObject\Notification;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Delete;

class NotificationMapper extends AbstractMapper implements NotificationMapperInterface
{

    /**
     *
     * @var Notification
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Notification $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $id
     *
     * @return Notification
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('notification');
         * $select->where([
         * 'id = ?' => $id
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->getPrototype());
         * }
         *
         * throw new \InvalidArgumentException("Notification with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Notification[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('notification');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['logical_connection_id'])) {
                    $select->where(
                        [
                            'logical_connection_id = ?' => $condition['logical_connection_id']
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());
            return $resultSet->initialize($result);
        }

        return [];

        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param Notification $dataObject
     *
     * @return Notification
     * @throws \Exception
     */
    public function save(Notification $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['email'] = $dataObject->getEmail();
        $data['success'] = $dataObject->getSuccess();
        $data['failure'] = $dataObject->getFailure();
        $data['logical_connection_id'] = $dataObject->getLogicalConnection()->getId();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        $action = new Insert('notification');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function deleteAll(array $criteria)
    {
        $action = new Delete('notification');

        $return = false;
        $conditionGiven = false;

        if (! empty($criteria)) {
            foreach ($criteria as $condition) {
                if (is_array($condition)) {
                    if (! empty($condition['logical_connection_id'])) {
                        $action->where(
                            [
                                'logical_connection_id = ?' => $condition['logical_connection_id']
                            ]);
                        $conditionGiven = true;
                    }
                }
            }
        }
        if ($conditionGiven) {
            $sql = new Sql($this->dbAdapter);
            $statement = $sql->prepareStatementForSqlObject($action);
            $result = $statement->execute();
            $return = (bool) $result->getAffectedRows();
        }

        return $return;
    }

}
