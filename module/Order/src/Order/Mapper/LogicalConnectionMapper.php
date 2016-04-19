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

class LogicalConnectionMapper implements LogicalConnectionMapperInterface
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
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
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
    public function find($id)
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
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
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
            'physical_connection_source' => 'physical_connection'
        ], 
            new Expression(
                'physical_connection_source.logical_connection_id = logical_connection.id AND physical_connection_source.role = ' .
                     '"' . AbstractPhysicalConnection::ROLE_SOURCE . '"'), [
                'physical_connection_source_id' => 'id'
            ], Select::JOIN_LEFT);
        
        $select->join([
            'physical_connection_target' => 'physical_connection'
        ], 
            new Expression(
                'physical_connection_target.logical_connection_id = logical_connection.id AND physical_connection_target.role = ' .
                     '"' . AbstractPhysicalConnection::ROLE_TARGET . '"'), [
                'physical_connection_target_id' => 'id'
            ], Select::JOIN_LEFT);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->prototype);
            $data = $result->current();
            
            if (!empty($data['physical_connection_source_id'])) {
                $return->setPhysicalConnectionSource($this->physicalConnectionMapper->findWithBuldledData($data['physical_connection_source_id']));
            }
            if (!empty($data['physical_connection_target_id'])) {
                $return->setPhysicalConnectionTarget($this->physicalConnectionMapper->findWithBuldledData($data['physical_connection_target_id']));
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
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $newPhysicalConnections = [];
                if ($dataObject->getPhysicalConnectionSource()) {
                    $dataObject->getPhysicalConnectionSource()->setLogicalConnection($dataObject);
                    $newPhysicalConnections[] = $this->physicalConnectionMapper->save(
                        $dataObject->getPhysicalConnectionSource());
                }
                if ($dataObject->getPhysicalConnectionTarget()) {
                    $dataObject->getPhysicalConnectionTarget()->setLogicalConnection($dataObject);
                    $newPhysicalConnections[] = $this->physicalConnectionMapper->save(
                        $dataObject->getPhysicalConnectionTarget());
                }
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
