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
use AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier;
use Order\Mapper\AbstractMapper;
use Order\Mapper\UserMapperInterface;
use Zend\Db\Sql\Expression;
use Order\Mapper\FileTransferRequestMapperInterface;
use Order\Mapper\ServerMapperInterface;
use Order\Mapper\ClusterMapperInterface;
use Zend\Paginator\Adapter\DbSelect;

class AuditLogMapper extends AbstractMapper implements AuditLogMapperInterface
{

    const PAGINATION_ITEM_COUNT_PER_PAGE = 25;

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
     * @var FileTransferRequestMapperInterface
     */
    protected $fileTransferRequestMapper;

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    /**
     *
     * @var ClusterMapperInterface
     */
    protected $clusterMapper;

    /**
     * @var AuditLogRequestModifier
     */
    protected $requestModifier;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, AuditLog $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param UserMapperInterface $fileTransferRequestMapper
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    /**
     *
     * @param FileTransferRequestMapperInterface $userMapper
     */
    public function setFileTransferRequestMapper(FileTransferRequestMapperInterface $fileTransferRequestMapper)
    {
        $this->fileTransferRequestMapper = $fileTransferRequestMapper;
    }

    /**
     *
     * @param AuditLogRequestModifier $auditLogRequestModifier
     */
    public function setRequestModifier(AuditLogRequestModifier $auditLogRequestModifier)
    {
        $this->requestModifier = $auditLogRequestModifier;
    }

    /**
     * @param ServerMapperInterface $serverMapper
     */
    public function setServerMapper($serverMapper)
    {
        $this->serverMapper = $serverMapper;
    }

    /**
     * @param ClusterMapperInterface $clusterMapper
     */
    public function setClusterMapper($clusterMapper)
    {
        $this->clusterMapper = $clusterMapper;
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

    /**
     *
     * @return array|AuditLog[]
     */
    public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $requstMode = AuditLogRequestModifier::REQUEST_MODE_REDUCED)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('audit_log');
        $prefix = 'audit_log__';
        $select->columns(
            [
                $prefix . 'id' => 'id',
                $prefix . 'resource_type' => 'resource_type',
                $prefix . 'resource_id' => 'resource_id',
                $prefix . 'action' => 'action',
                $prefix . 'event_datetime' => 'event_datetime',
            ]);
        if ($id) {
            $select->where([
                'audit_log.id = ?' => $id
            ]);
        }

        foreach ($criteria as $key => $condition) {
            if (is_string($condition) && ! empty($condition)) {
                if ($key === 'username') {
                    $select->where(
                        [
                            'user.username = ?' => $condition
                        ]);
                } elseif ($key === 'resuorce_type') {
                    $select->where(
                        [
                            'audit_log.resource_type = ?' => $condition
                        ]);
                } elseif ($key === 'change_number') {
                    $select->where(
                        [
                            'file_transfer_request.change_number = ?' => $condition
                        ]);
                }
            }
        }

        $select->join('user', 'audit_log.user_id = user.id',
            [
                'user' . '__' . 'id' => 'id',
                'user' . '__' . 'role' => 'role',
                'user' . '__' . 'username' => 'username'
            ], Join::JOIN_LEFT);

        $this->requestModifier->addFileTransferRequest($select);
        $this->requestModifier->addServer($select);
        $this->requestModifier->addCluster($select);

        $select->order(['audit_log__' . 'id' => 'ASC']);

        $adapter = new DbSelect($select, $this->dbAdapter, null, null);
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage(self::PAGINATION_ITEM_COUNT_PER_PAGE);
        $paginator->setCurrentPageNumber($page);

//         echo $select->getSqlString($this->dbAdapter->getPlatform());
//         die('');

        $resultSetArray = $paginator->getCurrentItems();

        if ($resultSetArray) {
            $resultSetArray = iterator_to_array($resultSetArray);
            foreach ($resultSetArray as $key => $arrayObject) {
                $resultSetArray[$key] = $arrayObject->getArrayCopy();
            }

//             echo '<pre>';
//             print_r($resultSetArray);
//             die(__FILE__);

            $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'audit_log__', null,
                null, null, null, false);

//             echo '<pre>';
//             print_r($dataObjects);
//             die('###');

            $paginator->setCurrentItems($dataObjects);

            return $paginator;
        }

        return [];
    }

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
        $data['resource_type'] = $dataObject->getResourceType();
        $data['resource_id'] = $dataObject->getResourceId();
        $data['action'] = $dataObject->getAction();
        $data['event_datetime'] = $dataObject->getEventDatetime();
        $data['user_id'] = $dataObject->getUser() ? $dataObject->getUser()->getId() : new Expression('NULL');
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

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        $userDataObjects = $this->userMapper->createDataObjects($resultSetArray, null, null, 'id', 'user__', $identifier,
            $prefix);
        $fileTransferRequestDataObjects = $this->fileTransferRequestMapper->createDataObjects($resultSetArray, null, null,
            'id', 'file_transfer_request__', $identifier, $prefix);
        $serverDataObjects = $this->serverMapper->createDataObjects($resultSetArray, null, null,
            'name', 'server__', $identifier, $prefix);
        $clusterDataObjects = $this->clusterMapper->createDataObjects($resultSetArray, null, null,
            'id', 'cluster__', $identifier, $prefix);

        foreach ($dataObjects as $key => $dataObject) {
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $userDataObjects, 'setUser', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $fileTransferRequestDataObjects,
                'setFileTransferRequest', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $serverDataObjects,
                'setServer', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $clusterDataObjects,
                'setCluster', 'getId');
        }

        return $dataObjects;
    }

}
