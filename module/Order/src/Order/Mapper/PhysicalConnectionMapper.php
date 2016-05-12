<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

class PhysicalConnectionMapper extends AbstractMapper implements PhysicalConnectionMapperInterface
{

    /**
     *
     * @var AbstractPhysicalConnection
     */
    protected $prototype;

    /**
     *
     * @var AbstractEndpointMapper
     */
    protected $endpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator)
    {
        parent::__construct($dbAdapter, $hydrator);
    }

    /**
     *
     * @param EndpointMapperInterface $endpointMapper            
     */
    public function setEndpointMapper(EndpointMapperInterface $endpointMapper)
    {
        $this->endpointMapper = $endpointMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractPhysicalConnectionMapper::find()
     */
    public function findOne($id)
    {
        // $this->prototype = new Endpoint{CONCRETE_TYPE}();
        
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
         * $select->where([
         * 'id = ?' => $id
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), clone $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("LogicalConnection with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return AbstractPhysicalConnection
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('physical_connection');
        $select->where([
            'physical_connection.id = ?' => $id
        ]);
        
        $select->join([
            'endpoint_source' => 'endpoint'
        ], 
            new Expression(
                'endpoint_source.physical_connection_id = physical_connection.id AND endpoint_source.role = ' . '"' .
                     AbstractEndpoint::ROLE_SOURCE . '"'), 
            [
                'endpoint_source_id' => 'id'
            ], Select::JOIN_LEFT);
        
        $select->join([
            'endpoint_target' => 'endpoint'
        ], 
            new Expression(
                'endpoint_target.physical_connection_id = physical_connection.id AND endpoint_target.role = ' . '"' .
                     AbstractEndpoint::ROLE_TARGET . '"'), 
            [
                'endpoint_target_id' => 'id'
            ], Select::JOIN_LEFT);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $data = $result->current();
            if (! empty($data['type'])) {
                if (strcasecmp($data['type'], LogicalConnection::TYPE_CD) === 0) {
                    $this->prototype = new PhysicalConnectionCd();
                } elseif (strcasecmp($data['type'], LogicalConnection::TYPE_FTGW) === 0) {
                    $this->prototype = new PhysicalConnectionFtgw();
                }
                $return = $this->hydrator->hydrate($result->current(), clone $this->prototype);
                
                if (! empty($data['endpoint_source_id'])) {
                    $return->setEndpointSource(
                        $this->endpointMapper->findWithBuldledData($data['endpoint_source_id']));
                }
                if (! empty($data['endpoint_target_id'])) {
                    $return->setEndpointTarget(
                        $this->endpointMapper->findWithBuldledData($data['endpoint_target_id']));
                }
            } else {
                $return = null;
            }
            
            return $return;
        }
    }

    /**
     *
     * @return array|AbstractPhysicalConnection[]
     */
    public function findAll(array $criteria = [])
    {
        // $this->prototype = new Endpoint{CONCRETE_TYPE}();
        
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, clone $this->prototype);
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
     * @param AbstractPhysicalConnection $dataObject            
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['role'] = $dataObject->getRole();
        $data['type'] = $dataObject->getType();
        // $data['foo'] = $dataObject->getFoo();
        $data['logical_connection_id'] = $dataObject->getLogicalConnection()->getId();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        // none
        
        $action = new Insert('physical_connection');
        $action->values($data);
        
        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                if ($dataObject->getEndpointSource()) {
                    $dataObject->getEndpointSource()->setPhysicalConnection($dataObject);
                    $newEndpointSource = $this->endpointMapper->save($dataObject->getEndpointSource());
                    $dataObject->setEndpointSource($newEndpointSource);
                }
                if ($dataObject->getEndpointTarget()) {
                    $dataObject->getEndpointTarget()->setPhysicalConnection($dataObject);
                    $newEndpointTarget = $this->endpointMapper->save($dataObject->getEndpointTarget());
                    $dataObject->setEndpointTarget($newEndpointTarget);
                }
            }
            $concreteSaveMethod = 'save' . $data['type'];
            $concreteDataObject = $this->$concreteSaveMethod($dataObject);
            return $concreteDataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param PhysicalConnectionCd $dataObject            
     *
     * @return PhysicalConnectionCd
     * @throws \Exception
     */
    public function saveCd(AbstractPhysicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['secure_plus'] = $dataObject->getSecurePlus();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['physical_connection_id'] = $dataObject->getId();
        
        $action = new Insert('physical_connection_cd');
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

    /**
     *
     * @param PhysicalConnectionFtgw $dataObject            
     *
     * @return PhysicalConnectionFtgw
     * @throws \Exception
     */
    public function saveFtgw(AbstractPhysicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['physical_connection_id'] = $dataObject->getId();
        
        $action = new Insert('physical_connection_ftgw');
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
