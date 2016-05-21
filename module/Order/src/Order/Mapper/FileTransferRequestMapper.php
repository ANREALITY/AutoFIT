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

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, FileTransferRequest $prototype, string $prefix = null, string $identifier = null)
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
        $prefix = 'file_transfer_request_';
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
                'user' . '_' . 'id' => 'id',
                'user' . '_' . 'role' => 'role',
                'user' . '_' . 'username' => 'username'
            ], Join::JOIN_LEFT);
        $select->join('logical_connection', 'logical_connection.id = file_transfer_request.logical_connection_id',
            [
                'logical_connection_id' => 'id',
                'logical_connection_type' => 'type'
            ], Select::JOIN_LEFT);
        $select->join('notification', 'notification.logical_connection_id = logical_connection.id',
            [
                'notification_id' => 'id',
                'notification_email' => 'email',
                'notification_success' => 'success',
                'notification_failure' => 'failure',
                'notification_logical_connection_id' => 'logical_connection_id'
            ], Select::JOIN_LEFT);
        $select->join(['service_invoice_position_basic' => 'service_invoice_position'],
            'service_invoice_position_basic.number = file_transfer_request.service_invoice_position_basic_number',
            [
                'service_invoice_position_basic' . '_' . 'number' => 'number',
                'service_invoice_position_basic' . '_' . 'order_quantity' => 'order_quantity',
                'service_invoice_position_basic' . '_' . 'description' => 'description',
                'service_invoice_position_basic' . '_' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_basic' . '_' . 'article_sku' => 'article_sku',
                'service_invoice_position_basic' . '_' . 'service_invoice_position_status_name' => 'service_invoice_position_status_name'
            ], Join::JOIN_LEFT);
        $select->join(['service_invoice_position_personal' => 'service_invoice_position'],
            'service_invoice_position_personal.number = file_transfer_request.service_invoice_position_personal_number',
            [
                'service_invoice_position_personal' . '_' . 'number' => 'number',
                'service_invoice_position_personal' . '_' . 'order_quantity' => 'order_quantity',
                'service_invoice_position_personal' . '_' . 'description' => 'description',
                'service_invoice_position_personal' . '_' . 'service_invoice_number' => 'service_invoice_number',
                'service_invoice_position_personal' . '_' . 'article_sku' => 'article_sku',
                'service_invoice_position_personal' . '_' . 'service_invoice_position_status_name' => 'service_invoice_position_status_name'
            ], Join::JOIN_LEFT);

        $select->join('service_invoice',
            'service_invoice.number = service_invoice_position_basic.service_invoice_number OR service_invoice.number = service_invoice_position_personal.service_invoice_number',
            [], Select::JOIN_LEFT);
        $select->join('application',
            'application.technical_short_name = service_invoice.application_technical_short_name',
            [
                'application_technical_short_name' => 'technical_short_name'
            ], Select::JOIN_LEFT);
        $select->join('environment', 'environment.severity = service_invoice.environment_severity',
            [
                'environment_severity' => 'severity',
                'environment_name' => 'name'
            ], Select::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());
            $return = $resultSet->initialize($result);
            
            $resultSet = new ResultSet();
            $resultSet->initialize($result);
            $resultSetArray = $resultSet->toArray();
            echo '<pre>';
            // print_r($resultSetArray);
            $dataObjects = $this->createDataObjects($resultSetArray, null, null, 'id', 'file_transfer_request_');
            // print_r($dataObjects);

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

    public function createDataObjects(
        array $resultSetArray,
        string $parentIdentifier = null, string $parentPrefix = null,
        string $identifier = null, string $prefix = null
    ) {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix);
        
        $logicalConnectionIdentifier = 'id';
        $logicalConnectionPrefix = 'logical_connection_';
        $logicalConnectionDataObjects = $this->logicalConnectionMapper->createDataObjects($resultSetArray, $identifier, $prefix,
            $logicalConnectionIdentifier, $logicalConnectionPrefix);
        
        $serviceInvoicePositionBasicIdentifier = 'number';
        $serviceInvoicePositionBasicPrefix = 'service_invoice_position_basic_';
        $serviceInvoicePositionBasicDataObjects = $this->serviceInvoicePositionMapper->createDataObjects($resultSetArray, $identifier, $prefix,
            $serviceInvoicePositionBasicIdentifier, $serviceInvoicePositionBasicPrefix);
        
        $serviceInvoicePositionPersonalIdentifier = 'number';
        $serviceInvoicePositionPersonalPrefix = 'service_invoice_position_personal_';
        $serviceInvoicePositionPersonalDataObjects = $this->serviceInvoicePositionMapper->createDataObjects($resultSetArray, $identifier, $prefix,
            $serviceInvoicePositionPersonalIdentifier, $serviceInvoicePositionPersonalPrefix);
        
        $userIdentifier = 'id';
        $userPrefix = 'user_';
        $userDataObjects = $this->userMapper->createDataObjects($resultSetArray, $identifier, $prefix,
            $userIdentifier, $userPrefix);
        
        // print_r($userDataObjects);
        
        foreach ($dataObjects as $key => $dataObject) {
            if (array_key_exists($dataObject->getId(), $logicalConnectionDataObjects)) {
                $dataObject->setLogicalConnection($logicalConnectionDataObjects[$dataObject->getId()]);
            }
            if (array_key_exists($dataObject->getId(), $serviceInvoicePositionBasicDataObjects)) {
                $dataObject->setServiceInvoicePositionBasic($serviceInvoicePositionBasicDataObjects[$dataObject->getId()]);
            }
            if (array_key_exists($dataObject->getId(), $serviceInvoicePositionPersonalDataObjects)) {
                $dataObject->setServiceInvoicePositionPersonal($serviceInvoicePositionPersonalDataObjects[$dataObject->getId()]);
            }
            if (array_key_exists($dataObject->getId(), $userDataObjects)) {
                $dataObject->setUser($userDataObjects[$dataObject->getId()]);
            }
        }
        
        print_r($dataObjects);
        
        return $dataObjects;
    }

}
