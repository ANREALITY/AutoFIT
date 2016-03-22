<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\PhysicalConnectionCd;

abstract class AbstractPhysicalConnectionMapper implements PhysicalConnectionMapperInterface
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
     * @var AbstractPhysicalConnection
     */
    protected $prototype;

    /**
     *
     * @var AbstractEndpointMapper
     */
    protected $endpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator,
        AbstractPhysicalConnection $prototype, AbstractEndpointMapper $endpointMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
        $this->endpointMapper = $endpointMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractPhysicalConnectionMapper::find()
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
     * @return array|AbstractPhysicalConnection[]
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
     * @param AbstractPhysicalConnection $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
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
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $newEndpoints = [];
                // @todo It's a hack! Decide between using a collection or two objects!!!
                $dataObject->setEndpoints(
                    [
                        $dataObject->getEndpointSource(),
                        $dataObject->getEndpointTarget()
                    ]);
                foreach ($dataObject->getEndpoints() as $endpoint) {
                    // @todo It's just a hack! Solve this another way!!!
                    if (! $endpoint->getPhysicalConnection()) {
                        $endpoint->setPhysicalConnection(new PhysicalConnectionCd());
                    }
                    if (! $endpoint->getPhysicalConnection()) {
                        $endpoint->getPhysicalConnection()->setAbstractPhysicalConnection(
                            new AbstractPhysicalConnection());
                    }
                    $endpoint->getPhysicalConnection()->setId($newId);
                    $newEndpoints[] = $this->endpointMapper->save($endpoint);
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }
}
