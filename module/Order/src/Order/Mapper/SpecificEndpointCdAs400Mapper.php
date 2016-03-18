<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractSpecificEndpoint;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\SpecificEndpointCdAs400;

class SpecificEndpointCdAs400Mapper extends AbstractSpecificEndpointMapper
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
     * @var BasicEndpointMapperInterface
     */
    protected $basicEndpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, 
        SpecificEndpointCdAs400 $prototype, BasicEndpointMapperInterface $basicEndpointMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->basicEndpointMapper = $basicEndpointMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractSpecificEndpointMapper::find()
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
     * @return array|AbstractSpecificEndpoint[]
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
     * @param SpecificEndpointCdAs400 $dataObject            
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractSpecificEndpoint $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        $newBasicEndpoint = $this->basicEndpointMapper->save($dataObject->getBasicEndpoint());
        // data from the recently persisted objects
        $data['endpoint_id'] = $newBasicEndpoint->getId();
        
        $action = new Insert('endpoint_cd_as400');
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
