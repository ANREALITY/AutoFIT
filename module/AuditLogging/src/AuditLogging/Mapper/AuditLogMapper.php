<?php
namespace AuditLogging\Mapper;

use AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier;
use DbSystel\DataObject\AuditLog;
use DbSystel\DataObject\AuditLogCluster;
use DbSystel\DataObject\AuditLogFileTransferRequest;
use DbSystel\DataObject\AuditLogServer;
use DbSystel\Paginator\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Order\Mapper\AbstractMapper;
use Order\Mapper\ClusterMapperInterface;
use Order\Mapper\FileTransferRequestMapperInterface;
use Order\Mapper\ServerMapperInterface;
use Order\Mapper\UserMapperInterface;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Join;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
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
     * @param FileTransferRequestMapperInterface $fileTransferRequestMapper
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
     * @param $id
     * @return AuditLog
     */
    public function findOne($id)
    {
        $repository = $this->entityManager->getRepository(AuditLog::class);
        $entity = $repository->find($id);
        /** @var AuditLog $entity */
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], $page = null, array $sorting = [])
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->entityManager->createQueryBuilder();
        if (array_key_exists('change_number', $criteria)) {
            $queryBuilder->select('al')->from(AuditLogFileTransferRequest::class, 'al');
            $queryBuilder->join('al.fileTransferRequest', 'ftr');
        } else {
            $queryBuilder->select('al')->from(AuditLog::class, 'al');
        }
        foreach ($criteria as $key => $condition) {
            if (is_string($condition) && ! empty($condition)) {
                if ($key === 'username') {
                    $queryBuilder
                        ->andWhere('u.username = :username')
                        ->setParameter('username', $condition);
                } elseif ($key === 'resource_type') {
                    $resourceTypeToClassMap = [
                        AuditLog::RESSOURCE_TYPE_ORDER => AuditLogFileTransferRequest::class,
                        AuditLog::RESSOURCE_TYPE_SERVER => AuditLogServer::class,
                        AuditLog::RESSOURCE_TYPE_CLUSTER => AuditLogCluster::class,
                    ];
                    $queryBuilder
                        ->andWhere($queryBuilder->expr()->isInstanceOf(
                            'al',
                            $resourceTypeToClassMap[$condition]
                        ))
                    ;
                } elseif ($key === 'change_number') {
                    $queryBuilder
                        ->andWhere('ftr.changeNumber = :changeNumber')
                        ->setParameter('changeNumber', $criteria['change_number'])
                    ;
                }
            }
        }
        foreach ($sorting as $key => $condition) {
            if (is_string($condition) && ! empty($condition)) {
                if ($key === 'datetime') {
                    $direction = strtoupper($condition) === 'ASC'
                        ? 'ASC' : 'DESC';
                    $queryBuilder->addOrderBy('al.datetime', $direction);
                }
            }
        }

        $queryBuilder->join('al.user', 'u');
        $query = $queryBuilder->getQuery();
        $paginator = new Paginator(new PaginatorAdapter(new ORMPaginator($query)));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemCountPerPage);
        $return = $paginator;
        return $return;
    }

    // @todo Remove the obsolete code!
//    /**
//     *
//     * @return array|AuditLog[]
//     */
//    public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $requstMode = AuditLogRequestModifier::REQUEST_MODE_REDUCED, array $sorting = [])
//    {
//        $sql = new Sql($this->dbAdapter);
//        $select = $sql->select('audit_log');
//        $prefix = 'audit_log__';
//        $select->columns(
//            [
//                $prefix . 'id' => 'id',
//                $prefix . 'resource_type' => 'resource_type',
//                $prefix . 'resource_id' => 'resource_id',
//                $prefix . 'action' => 'action',
//                $prefix . 'datetime' => 'datetime',
//            ]);
//        if ($id) {
//            $select->where([
//                'audit_log.id = ?' => $id
//            ]);
//        }
//
//        foreach ($criteria as $key => $condition) {
//            if (is_string($condition) && ! empty($condition)) {
//                if ($key === 'username') {
//                    $select->where(
//                        [
//                            'user.username = ?' => $condition
//                        ]);
//                } elseif ($key === 'resource_type') {
//                    $select->where(
//                        [
//                            'audit_log.resource_type = ?' => $condition
//                        ]);
//                } elseif ($key === 'change_number') {
//                    $select->where(
//                        [
//                            'file_transfer_request.change_number = ?' => $condition
//                        ]);
//                }
//            }
//        }
//
//        $select->order(['audit_log.datetime' => Select::ORDER_DESCENDING]);
//        foreach ($sorting as $key => $condition) {
//            if (is_string($condition) && ! empty($condition)) {
//                if ($key === 'datetime') {
//                    $direction = strtoupper($condition) === Select::ORDER_ASCENDING
//                        ? Select::ORDER_ASCENDING : Select::ORDER_DESCENDING;
//                    $select->order(['audit_log.' . $key => $direction]);
//                }
//            }
//        }
//
//        $select->join('user', 'audit_log.user_id = user.id',
//            [
//                'user' . '__' . 'id' => 'id',
//                'user' . '__' . 'role' => 'role',
//                'user' . '__' . 'username' => 'username'
//            ], Join::JOIN_LEFT);
//
//        $this->requestModifier->addFileTransferRequest($select);
//        $this->requestModifier->addServer($select);
//        $this->requestModifier->addCluster($select);
//
//        $adapter = new DbSelect($select, $this->dbAdapter, null, null);
//        $paginator = new Paginator($adapter);
//        $paginator->setItemCountPerPage($this->itemCountPerPage);
//        $paginator->setCurrentPageNumber($page);
//
////         echo $select->getSqlString($this->dbAdapter->getPlatform());
////         die('');
//
//        $resultSetArray = $paginator->getCurrentItems();
//
//        if ($resultSetArray) {
//            $resultSetArray = iterator_to_array($resultSetArray);
//            foreach ($resultSetArray as $key => $arrayObject) {
//                $resultSetArray[$key] = $arrayObject->getArrayCopy();
//            }
//
////             echo '<pre>';
////             print_r($resultSetArray);
////             die(__FILE__);
//
//            $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'audit_log__', null,
//                null, null, null, false);
//
////             echo '<pre>';
////             print_r($dataObjects);
////             die('###');
//
//            $paginator->setCurrentItems($dataObjects);
//
//            return $paginator;
//        }
//
//        return [];
//    }

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
        $data['datetime'] = $dataObject->getDatetime();
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

    // @todo Remove the obsolete code!
//    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
//        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
//        callable $dataObjectCondition = null, bool $isCollection = false)
//    {
//        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);
//
//        $userDataObjects = $this->userMapper->createDataObjects($resultSetArray, null, null, 'id', 'user__', $identifier,
//            $prefix);
//        $fileTransferRequestDataObjects = $this->fileTransferRequestMapper->createDataObjects($resultSetArray, null, null,
//            'id', 'file_transfer_request__', $identifier, $prefix);
//        $serverDataObjects = $this->serverMapper->createDataObjects($resultSetArray, null, null,
//            'name', 'server__', $identifier, $prefix);
//        $clusterDataObjects = $this->clusterMapper->createDataObjects($resultSetArray, null, null,
//            'id', 'cluster__', $identifier, $prefix);
//
//        foreach ($dataObjects as $key => $dataObject) {
//            $this->appendSubDataObject($dataObject, $dataObject->getId(), $userDataObjects, 'setUser', 'getId');
//            $this->appendSubDataObject($dataObject, $dataObject->getId(), $fileTransferRequestDataObjects,
//                'setFileTransferRequest', 'getId');
//            $this->appendSubDataObject($dataObject, $dataObject->getId(), $serverDataObjects,
//                'setServer', 'getId');
//            $this->appendSubDataObject($dataObject, $dataObject->getId(), $clusterDataObjects,
//                'setCluster', 'getId');
//        }
//
//        return $dataObjects;
//    }

}
