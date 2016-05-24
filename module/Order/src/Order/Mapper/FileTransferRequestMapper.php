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
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Db\Sql\Expression;
use DbSystel\DataObject\ServiceInvoicePosition;
use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;
use Zend\Db\Sql\Join;
use DbSystel\DataObject\Notification;

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

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, FileTransferRequest $prototype,
        string $prefix = null, string $identifier = null)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype, $prefix, $identifier);
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
     * @param int|string $id
     *
     * @return FileTransferRequest
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');
        $select->where([
            'file_transfer_request.id = ?' => $id
        ]);
        $select->columns(
            [
                'file_transfer_request' . '_' . 'id' => 'id',
                'file_transfer_request' . '_' . 'change_number' => 'change_number',
                'file_transfer_request' . '_' . 'status' => 'status',
                'file_transfer_request' . '_' . 'logical_connection_id' => 'logical_connection_id',
                'file_transfer_request' . '_' . 'service_invoice_position_basic_number' => 'service_invoice_position_basic_number',
                'file_transfer_request' . '_' . 'service_invoice_position_personal_number' => 'service_invoice_position_personal_number',
                'file_transfer_request' . '_' . 'user_id' => 'user_id'
            ]);
        $select->join('user', 'file_transfer_request.user_id = user.id',
            [
                'user' . '_' . 'id' => 'id',
                'user' . '_' . 'role' => 'role',
                'user' . '_' . 'username' => 'username'
            ], Join::JOIN_LEFT);
        $select->join('logical_connection', 'file_transfer_request.logical_connection_id = logical_connection.id',
            [
                'logical_connection' . '_' . 'id' => 'id',
                'logical_connection' . '_' . 'type' => 'type'
            ], Join::JOIN_LEFT);
        $select->join('notification', 'notification.logical_connection_id = logical_connection.id',
            [
                'notification' . '_' . 'id' => 'id',
                'notification' . '_' . 'email' => 'email',
                'notification' . '_' . 'success' => 'success',
                'notification' . '_' . 'failure' => 'failure',
                'notification' . '_' . 'logical_connection_id' => 'logical_connection_id'
            ], Join::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            foreach ($result as $column => $value) {
                $resultArray[] = $result->current();
            }
            $resultData = [];
            foreach ($resultArray as $resultRowArray) {
                foreach (array_keys($resultRowArray) as $arrayKey) {
                    $this->processResultRow($resultData, $resultRowArray, 'file_transfer_request' . '_',
                        'file_transfer_request', $arrayKey, 'file_transfer_request' . '_' . 'id');
                    $this->processResultRow($resultData, $resultRowArray, 'user' . '_', 'user', $arrayKey,
                        'user' . '_' . 'id');
                    $this->processResultRow($resultData, $resultRowArray, 'logical_connection' . '_',
                        'logical_connection', $arrayKey, 'logical_connection' . '_' . 'id');
                    $this->processResultRow($resultData, $resultRowArray, 'notification' . '_', 'notifications',
                        $arrayKey, 'notification' . '_' . 'id', 'logical_connection' . '_' . 'id');
                }
            }
            $fileTransferRequest = $this->hydrator->hydrate($resultData['file_transfer_request'][$id],
                $this->getPrototype());
            $logicalConnection = $this->hydrator->hydrate(
                $resultData['logical_connection'][$resultData['file_transfer_request'][$id]['logical_connection_id']],
                $this->getLogicalConnectionPrototype());
            $user = $this->hydrator->hydrate($resultData['user'][$resultData['file_transfer_request'][$id]['user_id']],
                $this->getUserPrototype());
            $fileTransferRequest->setUser($user);
            $fileTransferRequest->setLogicalConnection($logicalConnection);
            $notifications = [];
            foreach ($resultData['notifications'][$resultData['file_transfer_request'][$id]['logical_connection_id']] as $notification) {
                $notifications[] = $this->hydrator->hydrate($notification, $this->getNotificationPrototype());
            }
            $fileTransferRequest->getLogicalConnection()->setNotifications($notifications);

            // echo '<pre>';
            // print_r($resultData);
            // die();
            // $fileTransferRequest = new FileTransferRequest();
            // $fileTransferRequest->setId(777);

            return $fileTransferRequest;
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
    public function findAllWithBuldledData(array $criteria = [], $id = null)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');
        $prefix = 'file_transfer_request__';
        $select->columns(
            [
                $prefix . 'id' => 'id',
                $prefix . 'change_number' => 'change_number',
                $prefix . 'status' => 'status',
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
                'physical_connection' . '__' . 'type' => 'type'
            ], Select::JOIN_LEFT);
        $select->join('physical_connection_cd', 'physical_connection_cd.physical_connection_id = physical_connection.id',
            [
                'physical_connection_cd' . '__' . 'physical_connection_id' => 'physical_connection_id',
                'physical_connection_cd' . '__' . 'secure_plus' => 'secure_plus'
            ], Select::JOIN_LEFT);
        $select->join('physical_connection_ftgw', 'physical_connection_ftgw.physical_connection_id = physical_connection.id',
            [], Select::JOIN_LEFT);
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
                'service_invoice_position_basic' . '__' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_basic' . '__' . 'article_sku' => 'article_sku',
                'service_invoice_position_basic' . '__' . 'service_invoice_position_status_name' => 'service_invoice_position_status_name'
            ], Join::JOIN_LEFT);
        $select->join([
            'service_invoice_position_personal' => 'service_invoice_position'
        ], 'service_invoice_position_personal.number = file_transfer_request.service_invoice_position_personal_number',
            [
                'service_invoice_position_personal' . '__' . 'number' => 'number',
                'service_invoice_position_personal' . '__' . 'order_quantity' => 'order_quantity',
                'service_invoice_position_personal' . '__' . 'description' => 'description',
                'service_invoice_position_personal' . '__' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_personal' . '__' . 'article_sku' => 'article_sku',
                'service_invoice_position_personal' . '__' . 'service_invoice_position_status_name' => 'service_invoice_position_status_name'
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
                'application' . '__' . 'technical_id' => 'technical_id'
            ], Select::JOIN_LEFT);
        $select->join('environment', 'environment.severity = service_invoice.environment_severity',
            [
                'environment' . '__' . 'severity' => 'severity',
                'environment' . '__' . 'name' => 'name',
                'environment' . '__' . 'short_name' => 'short_name'
            ], Select::JOIN_LEFT);
        $select->join('endpoint', 'endpoint.physical_connection_id = physical_connection.id',
            [
                'endpoint' . '__' . 'id' => 'id',
                'endpoint' . '__' . 'physical_connection_id' => 'physical_connection_id',
                'endpoint' . '__' . 'role' => 'role',
                'endpoint' . '__' . 'type' => 'type',
                'endpoint' . '__' . 'server_place' => 'server_place',
                'endpoint' . '__' . 'contact_person' => 'contact_person'
            ], Select::JOIN_LEFT);
        $select->join(['endpoint_application' => 'application'],
            'endpoint_application.technical_short_name = endpoint.application_technical_short_name',
            [
                'endpoint_application' . '__' . 'technical_short_name' => 'technical_short_name',
                'endpoint_application' . '__' . 'technical_id' => 'technical_id'
            ], Select::JOIN_LEFT);
        $select->join('server',
            'server.name = endpoint.server_name',
            [
                'server' . '__' . 'name' => 'name'
            ], Select::JOIN_LEFT);
        $select->join('customer',
            'customer.id = endpoint.customer_id',
            [
                'customer' . '__' . 'id' => 'id',
                'customer' . '__' . 'name' => 'name'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_cd_as400', 'endpoint_cd_as400.endpoint_id = endpoint.id',
            [
                'endpoint_cd_as400' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_as400' . '__' . 'username' => 'username',
                'endpoint_cd_as400' . '__' . 'folder' => 'folder'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_cd_tandem', 'endpoint_cd_tandem.endpoint_id = endpoint.id',
            [
                'endpoint_cd_tandem' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_tandem' . '__' . 'username' => 'username',
                'endpoint_cd_tandem' . '__' . 'folder' => 'folder'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_cd_linux_unix', 'endpoint_cd_linux_unix.endpoint_id = endpoint.id',
            [
                'endpoint_cd_linux_unix' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_linux_unix' . '__' . 'username' => 'username',
                'endpoint_cd_linux_unix' . '__' . 'folder' => 'folder',
                'endpoint_cd_linux_unix' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_cd_linux_unix' . '__' . 'transmission_interval' => 'transmission_interval',
                'endpoint_cd_linux_unix' . '__' . 'cluster' => 'cluster',
                'endpoint_cd_linux_unix' . '__' . 'service_address' => 'service_address'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_cd_linux_unix_server', 'endpoint_cd_linux_unix_server.endpoint_cd_linux_unix_endpoint_id = endpoint_cd_linux_unix.endpoint_id',
            [], Select::JOIN_LEFT);
        $select->join(['cd_linux_unix_server' => 'server'],
            'cd_linux_unix_server.name = endpoint_cd_linux_unix_server.server_name',
            [
                'cd_linux_unix_server' . '__' . 'name' => 'name'
            ], Select::JOIN_LEFT);
        $select->join(['endpoint_cd_linux_unix_include_parameter_set' => 'include_parameter_set'], 'endpoint_cd_linux_unix_include_parameter_set.id = endpoint_cd_linux_unix.include_parameter_set_id',
            [
                'endpoint_cd_linux_unix_include_parameter_set' . '__' . 'id' => 'id'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_ftgw_windows', 'endpoint_ftgw_windows.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_windows' . '__' . 'endpoint_id' => 'endpoint_id',
            ], Select::JOIN_LEFT);
        $select->join('endpoint_ftgw_self_service', 'endpoint_ftgw_self_service.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_self_service' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_self_service' . '__' . 'ftgw_username' => 'ftgw_username',
                'endpoint_ftgw_self_service' . '__' . 'mailbox' => 'mailbox',
                'endpoint_ftgw_self_service' . '__' . 'connection_type' => 'connection_type'
            ], Select::JOIN_LEFT);
        $select->join('endpoint_ftgw_self_service_protocol', 'endpoint_ftgw_self_service_protocol.endpoint_ftgw_self_service_endpoint_id = endpoint_ftgw_self_service.endpoint_id',
            [], Select::JOIN_LEFT);
        $select->join(['ftgw_self_service_protocol' => 'protocol'],
            'ftgw_self_service_protocol.id = endpoint_ftgw_self_service_protocol.protocol_id',
            [
                'ftgw_self_service_protocol' . '__' . 'id' => 'id',
                'ftgw_self_service_protocol' . '__' . 'name' => 'name'
            ], Select::JOIN_LEFT);

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
            echo '<pre>';
            // print_r($resultSetArray);
            $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'file_transfer_request__', null,
                null, null, null, false);

            print_r($dataObjects);

            die('###');

            $fileTransferRequests = [];

            /**
             *
             * @var FileTransferRequest $fileTransferRequest
             */
            $fileTransferRequest;

            foreach ($return as $fileTransferRequest) {
                $data = $result->current();

                $fileTransferRequest->setUser($this->userMapper->findOne($data['user_id']));
                $fileTransferRequest->setLogicalConnection(
                    $this->logicalConnectionMapper->findWithBuldledData($data['logical_connection_id']));

                $fileTransferRequest->setServiceInvoicePositionBasic(new ServiceInvoicePosition());
                $fileTransferRequest->getServiceInvoicePositionBasic()->setServiceInvoice(new ServiceInvoice());
                $fileTransferRequest->getServiceInvoicePositionBasic()->setNumber(
                    $data['service_invoice_position_basic_number']);
                $fileTransferRequest->getServiceInvoicePositionBasic()
                    ->getServiceInvoice()
                    ->setApplication(new Application());
                $fileTransferRequest->getServiceInvoicePositionBasic()
                    ->getServiceInvoice()
                    ->setEnvironment(new Environment());
                $fileTransferRequest->getServiceInvoicePositionBasic()
                    ->getServiceInvoice()
                    ->getApplication()
                    ->setTechnicalShortName($data['application_technical_short_name']);
                $fileTransferRequest->getServiceInvoicePositionBasic()
                    ->getServiceInvoice()
                    ->getEnvironment()
                    ->setName($data['environment_name']);

                $fileTransferRequest->setServiceInvoicePositionPersonal(new ServiceInvoicePosition());
                $fileTransferRequest->getServiceInvoicePositionPersonal()->setNumber(
                    $data['service_invoice_position_personal_number']);
                $fileTransferRequest->getServiceInvoicePositionPersonal()->setServiceInvoice(new ServiceInvoice());
                $fileTransferRequest->getServiceInvoicePositionPersonal()
                    ->getServiceInvoice()
                    ->setApplication(new Application());
                $fileTransferRequest->getServiceInvoicePositionPersonal()
                    ->getServiceInvoice()
                    ->setEnvironment(new Environment());
                $fileTransferRequest->getServiceInvoicePositionPersonal()
                    ->getServiceInvoice()
                    ->getApplication()
                    ->setTechnicalShortName($data['application_technical_short_name']);
                $fileTransferRequest->getServiceInvoicePositionPersonal()
                    ->getServiceInvoice()
                    ->getEnvironment()
                    ->setName($data['environment_name']);

                $fileTransferRequests[] = $fileTransferRequest;
            }

            return $fileTransferRequests;
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
        $data['change_number'] = $dataObject->getChangeNumber();
        $data['service_invoice_position_basic_number'] = $dataObject->getServiceInvoicePositionBasic()->getNumber();
        $data['service_invoice_position_personal_number'] = $dataObject->getServiceInvoicePositionPersonal()->getNumber();
        if (empty($data['id'])) {
            $data['created'] = null;
            $data['updated'] = null;
        } else {
            unset($data['created']);
            $data['updated'] = null;
        }
        // creating sub-objects
        // $newFoo = $this->fooMapper->save($dataObject->getFoo());
        $newLogicalConnection = $this->logicalConnectionMapper->save($dataObject->getLogicalConnection());
        $dataObject->setLogicalConnection($newLogicalConnection);
        $newUser = $this->userMapper->save($dataObject->getUser());
        $dataObject->setUser($newUser);
        // data from the recently persisted objects
        $data['logical_connection_id'] = $newLogicalConnection->getId();
        $data['user_id'] = $newUser->getId();

        $action = new Insert('file_transfer_request');
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

}
