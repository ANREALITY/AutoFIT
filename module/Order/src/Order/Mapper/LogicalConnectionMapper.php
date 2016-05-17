<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\AbstractPhysicalConnection;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

class LogicalConnectionMapper extends AbstractMapper implements LogicalConnectionMapperInterface
{

    /**
     *
     * @var LogicalConnection
     */
    protected $prototype;

    /**
     *
     * @var PhysicalConnectionMapperInterface
     */
    protected $physicalConnectionMapper;

    /**
     *
     * @var NotificationMapperInterface
     */
    protected $notificationMapper;

    /**
     *
     * @var type
     */
    protected $type;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, LogicalConnection $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param PhysicalConnectionMapperInterface $physicalConnectionMapper
     */
    public function setPhysicalConnectionMapper(PhysicalConnectionMapperInterface $physicalConnectionMapper)
    {
        $this->physicalConnectionMapper = $physicalConnectionMapper;
    }

    /**
     *
     * @param NotificationMapperInterface $notificationMapper
     */
    public function setNotificationMapper(NotificationMapperInterface $notificationMapper)
    {
        $this->notificationMapper = $notificationMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return LogicalConnection
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
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
         * throw new \InvalidArgumentException("LogicalConnection with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|LogicalConnection[]
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
         * $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());
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
     * @return LogicalConnection
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('logical_connection');
        $select->where([
            'logical_connection.id = ?' => $id
        ]);

        $select->join([
            'physical_connection_end_to_end' => 'physical_connection'
        ],
            new Expression(
                'physical_connection_end_to_end.logical_connection_id = logical_connection.id AND physical_connection_end_to_end.role = ' .
                     '"' . AbstractPhysicalConnection::ROLE_END_TO_END . '"'),
            [
                'physical_connection_end_to_end_id' => 'id'
            ], Select::JOIN_LEFT);

        $select->join([
            'physical_connection_end_to_middle' => 'physical_connection'
        ],
            new Expression(
                'physical_connection_end_to_middle.logical_connection_id = logical_connection.id AND physical_connection_end_to_middle.role = ' .
                     '"' . AbstractPhysicalConnection::ROLE_END_TO_MIDDLE . '"'),
            [
                'physical_connection_end_to_middle_id' => 'id'
            ], Select::JOIN_LEFT);

        $select->join([
            'physical_connection_middle_to_end' => 'physical_connection'
        ],
            new Expression(
                'physical_connection_middle_to_end.logical_connection_id = logical_connection.id AND physical_connection_middle_to_end.role = ' .
                     '"' . AbstractPhysicalConnection::ROLE_MIDDLE_TO_END . '"'),
            [
                'physical_connection_middle_to_end_id' => 'id'
            ], Select::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());
            $data = $result->current();

            if (! empty($data['physical_connection_end_to_end_id'])) {
                $return->setPhysicalConnectionEndToEnd(
                    $this->physicalConnectionMapper->findWithBuldledData($data['physical_connection_end_to_end_id']));
            }
            if (! empty($data['physical_connection_end_to_middle_id'])) {
                $return->setPhysicalConnectionEndToMiddle(
                    $this->physicalConnectionMapper->findWithBuldledData($data['physical_connection_end_to_middle_id']));
            }
            if (! empty($data['physical_connection_middle_to_end_id'])) {
                $return->setPhysicalConnectionMiddleToEnd(
                    $this->physicalConnectionMapper->findWithBuldledData($data['physical_connection_middle_to_end_id']));
            }

            return $return;
        }

        throw new \InvalidArgumentException("LogicalConnection with given ID:{$id} not found.");
    }

    /**
     *
     * @param LogicalConnection $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(LogicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['type'] = $dataObject->getType();
        // creating sub-objects
        // data from the recently persisted objects

        $action = new Insert('logical_connection');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $newPhysicalConnections = [];
                if ($dataObject->getPhysicalConnectionEndToEnd()) {
                    $dataObject->getPhysicalConnectionEndToEnd()->setLogicalConnection($dataObject);
                    $newPhysicalConnections[] = $this->physicalConnectionMapper->save(
                        $dataObject->getPhysicalConnectionEndToEnd());
                }
                if ($dataObject->getPhysicalConnectionEndToMiddle()) {
                    $dataObject->getPhysicalConnectionEndToMiddle()->setLogicalConnection($dataObject);
                    $newPhysicalConnections[] = $this->physicalConnectionMapper->save(
                        $dataObject->getPhysicalConnectionEndToMiddle());
                }
                if ($dataObject->getPhysicalConnectionMiddleToEnd()) {
                    $dataObject->getPhysicalConnectionMiddleToEnd()->setLogicalConnection($dataObject);
                    $newPhysicalConnections[] = $this->physicalConnectionMapper->save(
                        $dataObject->getPhysicalConnectionMiddleToEnd());
                }
                $this->notificationMapper->deleteAll(
                    [
                        [
                            'logical_connection_id' => $dataObject->getId()
                        ]
                    ]);
                $newNotifications = [];
                foreach ($dataObject->getNotifications() as $notification) {
                    if ($notification->getEmail()) {
                        $notification->setLogicalConnection($dataObject);
                        $newNotifications[] = $this->notificationMapper->save($notification);
                    }
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
