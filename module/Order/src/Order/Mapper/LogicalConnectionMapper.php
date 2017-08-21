<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgwMiddleToEnd;
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
use DbSystel\DataObject\AbstractDataObject;
use DbSystel\DataObject\PhysicalConnectionCdEndToEnd;
use DbSystel\DataObject\PhysicalConnectionFtgwEndToMiddle;

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
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|LogicalConnection[]
     */
    public function findAll(array $criteria = [])
    {
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
        $data['id'] = $dataObject->getId();
        $data['type'] = $dataObject->getType();
        // creating sub-objects
        // data from the recently persisted objects

        if (! $data['id']) {
            $action = new Insert('logical_connection');
            $action->values($data);
        } else {
            $action = new Update('logical_connection');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
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
                if ($dataObject->getNotifications()) {
                    foreach ($dataObject->getNotifications() as $notification) {
                        if ($notification->getEmail()) {
                            $notification->setLogicalConnection($dataObject);
                            $newNotifications[] = $this->notificationMapper->save($notification, false);
                        }
                    }
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        $physicalConnectionEndToEndDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
            $identifier, $prefix, ['id', 'id'], ['physical_connection__', 'physical_connection_cd_end_to_end__'], null, null, new PhysicalConnectionCdEndToEnd(),
                function (array $row) {
                    return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_END_TO_END;
                });
        $physicalConnectionMiddleToEndDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
            $identifier, $prefix, ['id', 'id'], ['physical_connection__', 'physical_connection_ftgw_end_to_middle__'], null, null, new PhysicalConnectionFtgwEndToMiddle(),
                function (array $row) {
                    return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_END_TO_MIDDLE;
                });
        $physicalConnectionEndToMiddleDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
            $identifier, $prefix, ['id', 'id'], ['physical_connection__', 'physical_connection_ftgw_middle_to_end__'], null, null, new PhysicalConnectionFtgwMiddleToEnd(),
                function (array $row) {
                    return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_MIDDLE_TO_END;
                });
        $notificationDataObjects = $this->notificationMapper->createDataObjects($resultSetArray, $identifier, $prefix,
            'id', 'notification__', null, null, null, null, true);

        foreach ($dataObjects as $key => $dataObject) {
            // DANGEROUS!!!
            // Array key of a common element (created like myArray[] = new Element();)
            // can though equal to the $dataObject->getId()!!!!!
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionEndToEndDataObjects,
                'setPhysicalConnectionEndToEnd', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionMiddleToEndDataObjects,
                'setPhysicalConnectionEndToMiddle', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionEndToMiddleDataObjects,
                'setPhysicalConnectionMiddleToEnd', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $notificationDataObjects, 'setNotifications',
                'getId');
        }

        return $dataObjects;
    }

}
