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

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, FileTransferRequest $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
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
         * $select->where(array(
         * 'id = ?' => $id
         * ));
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
    public function findAll()
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('file_transfer_request');
         *
         * $stmt = $sql->prepareStatementForSqlObject($select);
         * $result = $stmt->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
         *
         * return $resultSet->initialize($result);
         * }
         *
         * return array();
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
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
        $fileTransferRequestData = [];
        $fileTransferRequestData['change_number'] = $dataObject->getChangeNumber();
        // @todo Only for testing! The logical connection ID needs to be retrieved from the new logical connection!
        $fileTransferRequestData['logical_connection_id'] = 1;
        $fileTransferRequestData['service_invoice_position_basic_number'] = $dataObject->getServiceInvoicePositionBasic()->getNumber();
        $fileTransferRequestData['service_invoice_position_personal_number'] = $dataObject->getServiceInvoicePositionPersonal()->getNumber();
        // @todo Only for testing! The user ID needs to be retrieved from the new user!
        $fileTransferRequestData['user_id'] = 1;
        
        $action = new Insert('file_transfer_request');
        $action->values($fileTransferRequestData);
        
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
