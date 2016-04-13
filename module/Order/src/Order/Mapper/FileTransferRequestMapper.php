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

class FileTransferRequestMapper implements FileTransferRequestMapperInterface
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
     * @var FileTransferRequest
     */
    protected $prototype;

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
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
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
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('file_transfer_request');
         * $select->where([
         * 'id = ?' => $id
         * ]);
         *
         * $stmt = $sql->prepareStatementForSqlObject($select);
         * $result = $stmt->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("FileTransferRequest with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
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
        
        $select->join('logical_connection', 'logical_connection.id = file_transfer_request.logical_connection_id', ['logical_connection_type' => 'type'], Select::JOIN_LEFT);
        
        $select->join('physical_connection', 'physical_connection.logical_connection_id = logical_connection.id', [], Select::JOIN_LEFT);
//         $select->join(['physical_connection_source' => 'physical_connection'], new Expression('physical_connection_source.logical_connection_id = logical_connection.id AND ' . 'physical_connection_source.role = "' . AbstractEndpoint::ROLE_SOURCE . '"'), [], Select::JOIN_LEFT);
//         $select->join(['physical_connection_target' => 'physical_connection'], new Expression('physical_connection_target.logical_connection_id = logical_connection.id AND ' . 'physical_connection_target.role = "' . AbstractEndpoint::ROLE_TARGET . '"'), [], Select::JOIN_LEFT);

        $select->join(['endpoint_source' => 'endpoint'], (new Expression('endpoint_source.physical_connection_id = physical_connection.id AND ' . 'endpoint_source.role = "' . AbstractEndpoint::ROLE_SOURCE . '"')), ['endpoint_source_id' => 'id', 'endpoint_source_role' => 'role', 'endpoint_source_server_name' => 'server_name'], Select::JOIN_LEFT);
        $select->join(['endpoint_target' => 'endpoint'], (new Expression('endpoint_target.physical_connection_id = physical_connection.id AND ' . 'endpoint_target.role = "' . AbstractEndpoint::ROLE_TARGET . '"')), ['endpoint_target_id' => 'id', 'endpoint_target_role' => 'role', 'endpoint_target_server_name' => 'server_name'], Select::JOIN_LEFT);
        $select->join(['service_invoice_position_basic' => 'service_invoice_position'], 'service_invoice_position_basic.number = file_transfer_request.service_invoice_position_basic_number', [], Select::JOIN_LEFT);
        $select->join(['service_invoice_position_personal' => 'service_invoice_position'], 'service_invoice_position_personal.number = file_transfer_request.service_invoice_position_personal_number', [], Select::JOIN_LEFT);
        $select->join('service_invoice', 'service_invoice.number = service_invoice_position_basic.service_invoice_number OR service_invoice.number = service_invoice_position_personal.service_invoice_number', [], Select::JOIN_LEFT);
        $select->join('application', 'application.technical_short_name = service_invoice.application_technical_short_name', ['application_technical_short_name' => 'technical_short_name'], Select::JOIN_LEFT);
        $select->join('environment', 'environment.severity = service_invoice.environment_severity', ['environment_severity' => 'severity', 'environment_name' => 'name'], Select::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            $return = $resultSet->initialize($result);

            $fileTransferRequests = [];

            /**
             * @var FileTransferRequest $fileTransferRequest
             */
            $fileTransferRequest;

            foreach ($return as $fileTransferRequest) {
                $data = $result->current();
                $fileTransferRequest->setLogicalConnection(new LogicalConnection());
                $fileTransferRequest->getLogicalConnection()->setType($data['logical_connection_type']);
                if ($data['logical_connection_type'] == LogicalConnection::TYPE_CD) {
                    $physicalConnectionSource = new PhysicalConnectionCd();
                    // $physicalConnectionSource->
                    $fileTransferRequest->getLogicalConnection()->setPhysicalConnectionSource($physicalConnectionSource);
                }
                if ($data['logical_connection_type'] == LogicalConnection::TYPE_FTGW) {
                    $physicalConnectionTarget = new PhysicalConnectionFtgw();
                    $fileTransferRequest->getLogicalConnection()->setPhysicalConnectionTarget($physicalConnectionTarget);
                }
                
                if ($data['id'] == 226) {
                    $breakpoint = null;
                }
            
            
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
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
