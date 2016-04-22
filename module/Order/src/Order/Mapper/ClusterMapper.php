<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ClusterMapper implements ClusterMapperInterface
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
     * @var Cluster
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Cluster $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id
     *
     * @return Cluster
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        throw new \InvalidArgumentException("Cluster with given id:{$id} not found.");
    }

    /**
     *
     * @return array|Cluster[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param Cluster $dataObject
     *
     * @return Cluster
     * @throws \Exception
     */
    public function save(Cluster $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['address'] = $dataObject->getAddress();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        $action = new Insert('cluster');
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
