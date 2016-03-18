<?php
namespace Order\Mapper;

use DbSystel\DataObject\LogicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class LogicalConnectionMapper implements LogicalConnectionMapperInterface
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
     * @var SpecificPhysicalConnectionMapperInterface
     */
    protected $specificPhysicalConnectionMapper;
    
    /**
     *
     * @var LogicalConnection
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, LogicalConnection $prototype,
        SpecificPhysicalConnectionMapperInterface $specificPhysicalConnectionMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->specificPhysicalConnectionMapper = $specificPhysicalConnectionMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return LogicalConnection
     * @throws \InvalidArgumentException
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
     * @return array|LogicalConnection[]
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
     * @param LogicalConnection $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(LogicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['type'] = $dataObject->getType();
        // creating sub-objects
        // data from the recently persisted objects

        $action = new Insert('logical_connection');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $newSpecificPhysicalConnections = [];
                foreach ($dataObject->getSpecificPhysicalConnections() as $specificPhysicalConnection) {
                    // @todo It's just a hack! Solve this another way!!!
                    if (!$specificPhysicalConnection->getBasicPhysicalConnection()->getLogicalConnection()) {
                        $specificPhysicalConnection->getBasicPhysicalConnection()->setLogicalConnection(new LogicalConnection());
                    }
                    $specificPhysicalConnection->getBasicPhysicalConnection()->getLogicalConnection()->setId($newId);
                    $newSpecificPhysicalConnections[] = $this->specificPhysicalConnectionMapper->save($specificPhysicalConnection);
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }
}
