<?php
namespace Order\Mapper;

use DbSystel\DataObject\BasicEndpoint;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class BasicEndpointMapper implements BasicEndpointMapperInterface
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
     * @var BasicEndpoint
     */
    protected $prototype;

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    /**
     *
     * @var ApplicationMapperInterface
     */
    protected $applicationMapper;

    /**
     *
     * @var CustomerMapperInterface
     */
    protected $customerMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, BasicEndpoint $prototype, 
        ServerMapperInterface $serverMapper, ApplicationMapperInterface $applicationMapper, 
        CustomerMapperInterface $customerMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->serverMapper = $serverMapper;
        $this->applicationMapper = $applicationMapper;
        $this->customerMapper = $customerMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see BasicEndpointMapper::find()
     */
    public function find($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
         * $select->where(array(
         * 'id = ?' => $id
         * ));
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
     * @return array|BasicEndpoint[]
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
     * @param BasicEndpoint $dataObject            
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(BasicEndpoint $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['role'] = $dataObject->getRole();
        $data['type'] = $dataObject->getType();
        $data['server_place'] = $dataObject->getServerPlace();
        $data['contact_person'] = $dataObject->getContactPerson();
        $data['physical_connection_id'] = $dataObject->getSpecificPhysicalConnection()
            ->getBasicPhysicalConnection()
            ->getId();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        $newServer = $this->serverMapper->save($dataObject->getServer());
        $newApplication = $this->applicationMapper->save($dataObject->getApplication());
        $newCustomer = $this->customerMapper->save($dataObject->getCustomer());
        // data from the recently persisted objects
        $data['server_name'] = $newServer->getId();
        $data['application_technical_short_name'] = $newApplication->getTechnicalShortName();
        $data['customer_id'] = $newCustomer->getId();
        
        $action = new Insert('endpoint');
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
