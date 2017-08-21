<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileTransferRequest;
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
use DbSystel\DataObject\PhysicalConnectionCdEndToEnd;
use DbSystel\DataObject\PhysicalConnectionFtgwEndToMiddle;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Db\Sql\Expression;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use Zend\Db\Sql\Join;
use DbSystel\DataObject\Notification;
use DbSystel\Paginator\Paginator;
use Order\Paginator\Adapter\FileTransferRequestPaginatorAdapter;
use Order\Mapper\RequestModifier\FileTransferRequestRequestModifier;

class FileTransferRequestMapper extends AbstractMapper implements FileTransferRequestMapperInterface
{

    /**
     *
     * @var FileTransferRequest
     */
    protected $prototype;

    /**
     *
     * @var LogicalConnection
     */
    protected $logicalConnectionPrototype;

    /**
     *
     * @var Notification
     */
    protected $notificationPrototype;

    /**
     *
     * @var LogicalConnectionMapperInterface
     */
    protected $logicalConnectionMapper;

    /**
     *
     * @var ServiceInvoicePositionMapperInterface
     */
    protected $serviceInvoicePositionMapper;

    /**
     *
     * @var UserMapperInterface
     */
    protected $userMapper;

    /**
     * @var FileTransferRequestRequestModifier
     */
    protected $requestModifier;

    public function __construct(
        AdapterInterface $dbAdapter,
        HydratorInterface $hydrator,
        FileTransferRequest $prototype,
        int $itemCountPerPage = null
    ) {
        parent::__construct($dbAdapter, $hydrator, $prototype, $itemCountPerPage);
    }

    /**
     *
     * @return the $userPrototype
     */
    public function getUserPrototype()
    {
        return clone $this->userPrototype;
    }

    /**
     *
     * @param User $userPrototype
     */
    public function setUserPrototype($userPrototype)
    {
        $this->userPrototype = $userPrototype;
    }

    /**
     *
     * @return the $logicalConnectionPrototype
     */
    public function getLogicalConnectionPrototype()
    {
        return clone $this->logicalConnectionPrototype;
    }

    /**
     *
     * @param LogicalConnection $logicalConnectionPrototype
     */
    public function setLogicalConnectionPrototype($logicalConnectionPrototype)
    {
        $this->logicalConnectionPrototype = $logicalConnectionPrototype;
    }

    /**
     *
     * @return the $notificationPrototype
     */
    public function getNotificationPrototype()
    {
        return clone $this->notificationPrototype;
    }

    /**
     *
     * @param Notification $notoficationPrototype
     */
    public function setNotificationPrototype($notoficationPrototype)
    {
        $this->notificationPrototype = $notoficationPrototype;
    }

    /**
     *
     * @param LogicalConnectionMapperInterface $logicalConnectionMapper
     */
    public function setLogicalConnectionMapper(LogicalConnectionMapperInterface $logicalConnectionMapper)
    {
        $this->logicalConnectionMapper = $logicalConnectionMapper;
    }

    /**
     *
     * @param ServiceInvoicePositionMapperInterface $serviceInvoicePositionMapper
     */
    public function setServiceInvoicePositionMapper(ServiceInvoicePositionMapperInterface $serviceInvoicePositionMapper)
    {
        $this->serviceInvoicePositionMapper = $serviceInvoicePositionMapper;
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
     * @param FileTransferRequestRequestModifier $fileTransferRequestRequestModifier
     */
    public function setRequestModifier(FileTransferRequestRequestModifier $fileTransferRequestRequestModifier)
    {
        $this->requestModifier = $fileTransferRequestRequestModifier;
    }

    /**
     *
     * @param int|string $id
     *
     * @return FileTransferRequest
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        $fileTransferRequests = $this->findAllWithBuldledData([], $id, null, false);
        if ($fileTransferRequests) {
            return $fileTransferRequests[0];
        }

        throw new \InvalidArgumentException("FileTransferRequest with given ID:{$id} not found.");
    }

    protected function processResultRow(array &$resultData, array $resultRowArray, string $tablePrefix,
        string $resultDataKey, string $arrayKey, string $indexColumn, string $parentColumn = null)
    {
        if (strpos($arrayKey, $tablePrefix) === 0) {
            $keyForHydration = substr($arrayKey, strlen($tablePrefix), strlen($arrayKey) - 1);
            if (! $parentColumn) {
                $indexValue = $resultRowArray[$indexColumn];
                $resultData[$resultDataKey][$indexValue][$keyForHydration] = $resultRowArray[$arrayKey];
            } else {
                $parentValue = $resultRowArray[$parentColumn];
                $indexValue = $resultRowArray[$indexColumn];
                $resultData[$resultDataKey][$parentValue][$indexValue][$keyForHydration] = $resultRowArray[$arrayKey];
            }
        }
    }

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['change_number'])) {
                    $select->where(
                        [
                            'change_number LIKE ?' => '%' . $condition['change_number'] . '%'
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());

            $return = $resultSet->initialize($result);

            return $return;
        }

        return [];
    }

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $paginationNeeded = true, $requstMode = FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');
        $prefix = 'file_transfer_request__';
        $select->columns(
            [
                $prefix . 'id' => 'id',
                $prefix . 'change_number' => 'change_number',
                $prefix . 'status' => 'status',
                $prefix . 'comment' => 'comment',
                $prefix . 'created' => 'created',
                $prefix . 'updated' => 'updated',
                $prefix . 'logical_connection_id' => 'logical_connection_id',
                $prefix . 'service_invoice_position_basic_number' => 'service_invoice_position_basic_number',
                $prefix . 'service_invoice_position_personal_number' => 'service_invoice_position_personal_number'
            ]);
        if ($id) {
            $select->where([
                'file_transfer_request.id = ?' => $id
            ]);
        }

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('user_id', $condition)) {
                    $select->where(
                        [
                            'user_id = ?' => $condition['user_id']
                        ]);
                }
            }
        }

        $select->join('user', 'file_transfer_request.user_id = user.id',
            [
                'user' . '__' . 'id' => 'id',
                'user' . '__' . 'role' => 'role',
                'user' . '__' . 'username' => 'username'
            ], Join::JOIN_LEFT);
        $select->join('logical_connection', 'logical_connection.id = file_transfer_request.logical_connection_id',
            [
                'logical_connection' . '__' . 'id' => 'id',
                'logical_connection' . '__' . 'type' => 'type'
            ], Select::JOIN_LEFT);
        $select->join('physical_connection', 'physical_connection.logical_connection_id = logical_connection.id',
            [
                'physical_connection' . '__' . 'id' => 'id',
                'physical_connection' . '__' . 'logical_connection_id' => 'logical_connection_id',
                'physical_connection' . '__' . 'role' => 'role',
                'physical_connection' . '__' . 'type' => 'type',
                'physical_connection' . '__' . 'secure_plus' => 'secure_plus'
            ], Select::JOIN_LEFT);
        $select->join('physical_connection_cd_end_to_end', 'physical_connection_cd_end_to_end.id = physical_connection.id',
            [
                'physical_connection_cd_end_to_end' . '__' . 'id' => 'id'
            ], Select::JOIN_LEFT);
        $select->join('physical_connection_ftgw_end_to_middle', 'physical_connection_ftgw_end_to_middle.id = physical_connection.id',
            [
                'physical_connection_ftgw_end_to_middle' . '__' . 'id' => 'id',
            ], Select::JOIN_LEFT);
        $select->join('physical_connection_ftgw_middle_to_end', 'physical_connection_ftgw_middle_to_end.id = physical_connection.id',
            [
                'physical_connection_ftgw_middle_to_end' . '__' . 'id' => 'id',
            ], Select::JOIN_LEFT);
        $select->join('notification', 'notification.logical_connection_id = logical_connection.id',
            [
                'notification' . '__' . 'id' => 'id',
                'notification' . '__' . 'email' => 'email',
                'notification' . '__' . 'success' => 'success',
                'notification' . '__' . 'failure' => 'failure',
                'notification' . '__' . 'logical_connection_id' => 'logical_connection_id'
            ], Select::JOIN_LEFT);
        $select->join([
            'service_invoice_position_basic' => 'service_invoice_position'
        ], 'service_invoice_position_basic.number = file_transfer_request.service_invoice_position_basic_number',
            [
                'service_invoice_position_basic' . '__' . 'number' => 'number',
                'service_invoice_position_basic' . '__' . 'order_quantity' => 'order_quantity',
                'service_invoice_position_basic' . '__' . 'description' => 'description',
                'service_invoice_position_basic' . '__' . 'status' => 'status',
                'service_invoice_position_basic' . '__' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_basic' . '__' . 'article_sku' => 'article_sku'
            ], Join::JOIN_LEFT);
        $select->join([
            'service_invoice_position_personal' => 'service_invoice_position'
        ], 'service_invoice_position_personal.number = file_transfer_request.service_invoice_position_personal_number',
            [
                'service_invoice_position_personal' . '__' . 'number' => 'number',
                'service_invoice_position_personal' . '__' . 'order_quantity' => 'order_quantity',
                'service_invoice_position_personal' . '__' . 'description' => 'description',
                'service_invoice_position_personal' . '__' . 'status' => 'status',
                'service_invoice_position_personal' . '__' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_personal' . '__' . 'article_sku' => 'article_sku'
            ], Join::JOIN_LEFT);

        $select->join('service_invoice',
            'service_invoice.number = service_invoice_position_basic.service_invoice_number OR service_invoice.number = service_invoice_position_personal.service_invoice_number',
            [
                'service_invoice' . '__' . 'number' => 'number',
                'service_invoice' . '__' . 'description' => 'description',
            ], Select::JOIN_LEFT);
        $select->join('application',
            'application.technical_short_name = service_invoice.application_technical_short_name',
            [
                'application' . '__' . 'technical_short_name' => 'technical_short_name',
                'application' . '__' . 'technical_id' => 'technical_id',
                'application' . '__' . 'active' => 'active'
            ], Select::JOIN_LEFT);
        $select->join('environment', 'environment.severity = service_invoice.environment_severity',
            [
                'environment' . '__' . 'severity' => 'severity',
                'environment' . '__' . 'name' => 'name',
                'environment' . '__' . 'short_name' => 'short_name'
            ], Select::JOIN_LEFT);

        $this->requestModifier->addEndpoint($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
        if ($id) {
            $endpointTypes = $this->getEndpointTypesByOrder($id);
            foreach ($endpointTypes as $endpointTypeNeeded) {
                $endpointAddMethodName = 'add' . $endpointTypeNeeded;
                $this->requestModifier->$endpointAddMethodName($select, FileTransferRequestRequestModifier::REQUEST_MODE_FULL);
            }
        } else {
            $this->requestModifier->addCdAs400($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addCdTandem($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addCdLinuxUnix($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addCdWindows($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addCdWindowsShare($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addCdZos($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwWindows($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwSelfService($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwProtocolServer($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwWindowsShare($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwLinuxUnix($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwCdZos($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwCdTandem($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
            $this->requestModifier->addFtgwCdAs400($select, FileTransferRequestRequestModifier::REQUEST_MODE_REDUCED);
        }

        $select->order(['file_transfer_request__' . 'id' => 'ASC']);

        $userId = isset($condition['user_id']) ? $condition['user_id'] : null;

        if (! $id) {
            $adapter = new FileTransferRequestPaginatorAdapter($select, $this->dbAdapter, null, null, $userId);
            $paginator = new Paginator($adapter);
            $paginator->setCurrentPageNumber($page);
            if ($paginationNeeded) {
                $paginator->setItemCountPerPage($this->itemCountPerPage);
            }

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

                $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'file_transfer_request__', null,
                    null, null, null, false);

//             echo '<pre>';
//             print_r($dataObjects);
//             die('###');

                $paginator->setCurrentItems($dataObjects);

                return $paginator;
            }

        } else {
            $statement = $sql->prepareStatementForSqlObject($select);

//         echo $select->getSqlString($this->dbAdapter->getPlatform());
//         die('');

            $result = $statement->execute();

            if ($result instanceof ResultInterface && $result->isQueryResult()) {
                $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());
                $return = $resultSet->initialize($result);

                $resultSet = new ResultSet();
                $resultSet->initialize($result);
                $resultSetArray = $resultSet->toArray();
                // echo '<pre>';
                // print_r($resultSetArray);
                $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'file_transfer_request__', null,
                    null, null, null, false);

//             echo '<pre>';
//             print_r($dataObjects);
//             die('###');

                return $dataObjects;
            }
        }

        return [];
    }

    /**
     *
     * @param FileTransferRequest $dataObject
     *
     * @return FileTransferRequest
     * @throws \Exception
     */
    public function save(FileTransferRequest $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['change_number'] = $dataObject->getChangeNumber();
        $data['service_invoice_position_basic_number'] = $dataObject->getServiceInvoicePositionBasic()->getNumber();
        $data['service_invoice_position_personal_number'] = $dataObject->getServiceInvoicePositionPersonal()->getNumber();
        if ($dataObject->getStatus()) {
            $data['status'] = $dataObject->getStatus();
        }
        $data['comment'] = $dataObject->getComment();
        // creating sub-objects
        // $newFoo = $this->fooMapper->save($dataObject->getFoo());
        $newLogicalConnection = $this->logicalConnectionMapper->save($dataObject->getLogicalConnection());
        $dataObject->setLogicalConnection($newLogicalConnection);
        $newUser = $this->userMapper->save($dataObject->getUser());
        $dataObject->setUser($newUser);
        // data from the recently persisted objects
        $data['logical_connection_id'] = $newLogicalConnection->getId();
        $data['user_id'] = $newUser->getId();

        if (! $data['id']) {
            $action = new Insert('file_transfer_request');
            unset($data['id']);
            $action->values($data);
        } else {
            $action = new Update('file_transfer_request');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            unset($data['change_number']);
            $action->set($data);
        }

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

        $logicalConnectionDataObjects = $this->logicalConnectionMapper->createDataObjects($resultSetArray, null, null,
            'id', 'logical_connection__', $identifier, $prefix);
        $serviceInvoicePositionBasicDataObjects = $this->serviceInvoicePositionMapper->createDataObjects(
            $resultSetArray, null, null, 'number', 'service_invoice_position_basic__', $identifier, $prefix);
        $serviceInvoicePositionPersonalDataObjects = $this->serviceInvoicePositionMapper->createDataObjects(
            $resultSetArray, null, null, 'number', 'service_invoice_position_personal__', $identifier, $prefix);
        $userDataObjects = $this->userMapper->createDataObjects($resultSetArray, null, null, 'id', 'user__', $identifier,
            $prefix);

        foreach ($dataObjects as $key => $dataObject) {
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $logicalConnectionDataObjects,
                'setLogicalConnection', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $serviceInvoicePositionBasicDataObjects,
                'setServiceInvoicePositionBasic', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $serviceInvoicePositionPersonalDataObjects,
                'setServiceInvoicePositionPersonal', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $userDataObjects, 'setUser', 'getId');
        }

        return $dataObjects;
    }

    protected function getEndpointTypesByOrder($orderId)
    {
        $return = [];

        $sql = new Sql($this->dbAdapter);

        $select = $sql->select('file_transfer_request');
        if ($orderId) {
            $select->where([
                'file_transfer_request.id = ?' => $orderId
            ]);
        }

        $select->columns([]);
        $select->join('logical_connection', 'logical_connection.id = file_transfer_request.logical_connection_id',
            [], Select::JOIN_LEFT);
        $select->join('physical_connection', 'physical_connection.logical_connection_id = logical_connection.id',
            [], Select::JOIN_LEFT);
        $select->join('physical_connection_cd_end_to_end', 'physical_connection_cd_end_to_end.id = physical_connection.id',
            [], Select::JOIN_LEFT);
        $select->join('physical_connection_ftgw_end_to_middle', 'physical_connection_ftgw_end_to_middle.id = physical_connection.id',
            [], Select::JOIN_LEFT);
        $select->join('physical_connection_ftgw_middle_to_end', 'physical_connection_ftgw_middle_to_end.id = physical_connection.id',
            [], Select::JOIN_LEFT);
        $select->join('endpoint', 'endpoint.physical_connection_id = physical_connection.id',
            [
                'endpoint' . '__' . 'type' => 'type',
            ], Select::JOIN_LEFT);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new ResultSet();
            $resultSetInitialized = $resultSet->initialize($result);
            $resultArray = $resultSetInitialized->toArray();
            $endpointTypes = array_column($resultArray, 'endpoint__type');
            $return = array_unique($endpointTypes);
        }
        
        return $return;
    }

}
