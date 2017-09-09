<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgwMiddleToEnd;
use Doctrine\ORM\EntityManager;
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

}
