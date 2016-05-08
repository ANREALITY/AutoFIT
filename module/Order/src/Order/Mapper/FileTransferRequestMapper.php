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
     * @var LogicalConnectionMapperInterface
     */
    protected $logicalConnectionMapper;

    /**
     *
     * @var UserMapperInterface
     */
    protected $userMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, FileTransferRequest $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     * @param LogicalConnection $logicalConnectionPrototype
     */
    public function setLogicalConnectionPrototype($logicalConnectionPrototype)
    {
        $this->logicalConnectionPrototype = $logicalConnectionPrototype;
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
        $select->columns([
            'file_transfer_request' . '_' . 'id' => 'id',
            'file_transfer_request' . '_' . 'change_number' => 'change_number',
            'file_transfer_request' . '_' . 'status' => 'status',
            'file_transfer_request' . '_' . 'logical_connection_id' => 'logical_connection_id',
            'file_transfer_request' . '_' . 'service_invoice_position_basic_number' => 'service_invoice_position_basic_number',
            'file_transfer_request' . '_' . 'service_invoice_position_personal_number' => 'service_invoice_position_personal_number',
            'file_transfer_request' . '_' . 'user_id' => 'user_id',
        ]);
        $select->join('logical_connection', 'file_transfer_request.id = logical_connection.id', [
            'logical_connection' . '_' . 'id' => 'id',
            'logical_connection' . '_' . 'type' => 'type',
        ], Join::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $resultArray = ['file_transfer_request', 'logical_connection'];
            foreach ($result->current() as $column => $value) {
                if (strpos($column, 'file_transfer_request') === 0) {
                    $keyForHydration = substr($column, strlen('file_transfer_request' . '_'), strlen($column) - 1);
                    $resultArray['file_transfer_request'][$keyForHydration] = $value;
                }
                if (strpos($column, 'logical_connection') === 0) {
                    $keyForHydration = substr($column, strlen('logical_connection' . '_'), strlen($column) - 1);
                    $resultArray['file_transfer_request']['logical_connection'][$keyForHydration] = $value;
                }
            }

            $fileTransferRequest = $this->hydrator->hydrate($resultArray['file_transfer_request'], $this->prototype);
            $logicalConnection = $this->hydrator->hydrate($resultArray['file_transfer_request']['logical_connection'], $this->prototype);
            $fileTransferRequest->setLogicalConnection($logicalConnection);

            return $fileTransferRequest;
        }

        throw new \InvalidArgumentException("FileTransferRequest with given ID:{$id} not found.");
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
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            $return = $resultSet->initialize($result);

            return $return;
        }

        return [];
    }

    /**
     *
     * @return array|FileTransferRequest[]
     */
    public function findAllWithBuldledData(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_transfer_request');

        $select->join('logical_connection', 'logical_connection.id = file_transfer_request.logical_connection_id',
            [
                'logical_connection_type' => 'type'
            ], Select::JOIN_LEFT);
        $select->join([
            'service_invoice_position_basic' => 'service_invoice_position'
        ], 'service_invoice_position_basic.number = file_transfer_request.service_invoice_position_basic_number', [],
            Select::JOIN_LEFT);
        $select->join([
            'service_invoice_position_personal' => 'service_invoice_position'
        ], 'service_invoice_position_personal.number = file_transfer_request.service_invoice_position_personal_number',
            [], Select::JOIN_LEFT);
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
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            $return = $resultSet->initialize($result);

            $fileTransferRequests = [];

            /**
             *
             * @var FileTransferRequest $fileTransferRequest
             */
            $fileTransferRequest;

            foreach ($return as $fileTransferRequest) {
                $data = $result->current();

                $fileTransferRequest->setLogicalConnection(
                    $this->logicalConnectionMapper->findWithBuldledData($data['logical_connection_id']));
                $fileTransferRequest->setServiceInvoicePositionBasic(new ServiceInvoicePosition());
                $fileTransferRequest->getServiceInvoicePositionBasic()->setServiceInvoice(new ServiceInvoice());
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

                $fileTransferRequest->setLogicalConnection(
                    $this->logicalConnectionMapper->findWithBuldledData($data['logical_connection_id']));
                $fileTransferRequest->setServiceInvoicePositionPersonal(new ServiceInvoicePosition());
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

}
