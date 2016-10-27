<?php
namespace AuditLogging\Mapper;

use DbSystel\DataObject\AuditLog;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use Zend\Db\Sql\Join;
use DbSystel\DataObject\Notification;
use DbSystel\Paginator\Paginator;
use AuditLogging\Paginator\Adapter\AuditLogPaginatorAdapter;
use AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier;
use Order\Mapper\AbstractMapper;
use Order\Mapper\UserMapperInterface;

class AuditLogMapper extends AbstractMapper implements AuditLogMapperInterface
{

    /**
     *
     * @var AuditLog
     */
    protected $prototype;

    /**
     *
     * @var UserMapperInterface
     */
    protected $userMapper;

    /**
     *
     * @var type
     */
    protected $type;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, AuditLog $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param UserMapperInterface $userMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return AuditLog
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        $paginator = $this->findAllWithBuldledData([], $id, null, false);
        $auditLogs = $paginator->getCurrentItems();
        if ($auditLogs) {
            return $auditLogs[0];
        }

        throw new \InvalidArgumentException("AuditLog with given ID:{$id} not found.");
    }

    /**
     *
     * @return array|AuditLog[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

//     /**
//      *
//      * @return array|AuditLog[]
//      */
//     public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $paginationNeeded = true, $requstMode = AuditLogRequestModifier::REQUEST_MODE_REDUCED)
//     {
//         $sql = new Sql($this->dbAdapter);
//         $select = $sql->select('audit_log');
//         $prefix = 'audit_log__';
//         $select->columns(
//             [
//                 $prefix . 'id' => 'id',
//                 $prefix . 'resource_type' => 'resource_type',
//                 $prefix . 'resource_id' => 'resource_id',
//                 $prefix . 'action' => 'action',
//                 $prefix . 'event_datetime' => 'event_datetime'
//             ]);
//         if ($id) {
//             $select->where([
//                 'audit_log.id = ?' => $id
//             ]);
//         }

//         foreach ($criteria as $condition) {
//             if (is_array($condition)) {
//                 if (array_key_exists('user_id', $condition)) {
//                     $select->where(
//                         [
//                             'user_id = ?' => $condition['user_id']
//                         ]);
//                 }
//             }
//         }

//         $select->join('user', 'audit_log.user_id = user.id',
//             [
//                 'user' . '__' . 'id' => 'id',
//                 'user' . '__' . 'role' => 'role',
//                 'user' . '__' . 'username' => 'username'
//             ], Join::JOIN_LEFT);

//         $select->order(['audit_log__' . 'id' => 'ASC']);

//         $userId = isset($condition['user_id']) ? $condition['user_id'] : null;
//         $adapter = new AuditLogPaginatorAdapter($select, $this->dbAdapter, null, null, $userId);
//         $paginator = new Paginator($adapter);
//         $paginator->setCurrentPageNumber($page);
//         if (! $paginationNeeded) {
//             $paginator->setItemCountPerPage(null);
//         }

// //         echo $select->getSqlString($this->dbAdapter->getPlatform());
// //         die('');

//         $resultSetArray = $paginator->getCurrentItems();

//         if ($resultSetArray) {
//             $resultSetArray = iterator_to_array($resultSetArray);
//             foreach ($resultSetArray as $key => $arrayObject) {
//                 $resultSetArray[$key] = $arrayObject->getArrayCopy();
//             }
            
// //             echo '<pre>';
// //             print_r($resultSetArray);
// //             die(__FILE__);

//             $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'audit_log__', null,
//                 null, null, null, false);

// //             echo '<pre>';
// //             print_r($dataObjects);
// //             die('###');

//             $paginator->setCurrentItems($dataObjects);

//             return $paginator;
//         }

//         return [];
//     }

    /**
     *
     * @param AuditLog $dataObject
     *
     * @return AuditLog
     * @throws \Exception
     */
    public function save(AuditLog $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['resource_type'] = $dataObject->getResuorceType();
        $data['resource_id'] = $dataObject->getResuorceId();
        $data['action'] = $dataObject->getAction();
        $data['event_datetime'] = $dataObject->getEventDatetime();
        $data['user_id'] = $dataObject->getUser()->getId();
        // creating sub-objects
        // $newFoo = $this->fooMapper->save($dataObject->getFoo());
        // data from the recently persisted objects

        $action = new Insert('audit_log');
        unset($data['id']);
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

//     public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
//         $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
//         callable $dataObjectCondition = null, bool $isCollection = false)
//     {
//         $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

//         $physicalConnectionEndToEndDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
//             $identifier, $prefix, ['id', 'physical_connection_id'], ['physical_connection__', 'physical_connection_cd__'], null, null, new PhysicalConnectionCd(),
//                 function (array $row) {
//                     return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_END_TO_END;
//                 });
//         $physicalConnectionMiddleToEndDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
//             $identifier, $prefix, ['id', 'physical_connection_id'], ['physical_connection__', 'physical_connection_ftgw__'], null, null, new PhysicalConnectionFtgw(),
//                 function (array $row) {
//                     return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_END_TO_MIDDLE;
//                 });
//         $physicalConnectionEndToMiddleDataObjects = $this->physicalConnectionMapper->createDataObjects($resultSetArray,
//             $identifier, $prefix, ['id', 'physical_connection_id'], ['physical_connection__', 'physical_connection_ftgw__'], null, null, new PhysicalConnectionFtgw(),
//                 function (array $row) {
//                     return array_key_exists('physical_connection' . '__' . 'role', $row) && $row['physical_connection' . '__' . 'role'] === AbstractPhysicalConnection::ROLE_MIDDLE_TO_END;
//                 });
//         $userDataObjects = $this->userMapper->createDataObjects($resultSetArray, $identifier, $prefix,
//             'id', 'user__', null, null, null, null, true);

//         foreach ($dataObjects as $key => $dataObject) {
//             // DANGEROUS!!!
//             // Array key of a common element (created like myArray[] = new Element();)
//             // can though equal to the $dataObject->getId()!!!!!
//             $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionEndToEndDataObjects,
//                 'setPhysicalConnectionEndToEnd', 'getId');
//             $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionMiddleToEndDataObjects,
//                 'setPhysicalConnectionEndToMiddle', 'getId');
//             $this->appendSubDataObject($dataObject, $dataObject->getId(), $physicalConnectionEndToMiddleDataObjects,
//                 'setPhysicalConnectionMiddleToEnd', 'getId');
//             $this->appendSubDataObject($dataObject, $dataObject->getId(), $userDataObjects, 'setUser',
//                 'getId');
//         }

//         return $dataObjects;
//     }

}
