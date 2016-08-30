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
use Zend\Db\Sql\Delete;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;

class ClusterMapper extends AbstractMapper implements ClusterMapperInterface
{

    /**
     *
     * @var Cluster
     */
    protected $prototype;

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Cluster $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param ServerMapperInterface $serverMapper
     */
    public function setServerMapper(ServerMapperInterface $serverMapper)
    {
        $this->serverMapper = $serverMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return Cluster
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Cluster[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('cluster');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('id', $condition)) {
                    $select->where(
                        [
                            'id = ?' => $condition['id']
                        ]);
                }
                if (array_key_exists('virtual_node_name', $condition)) {
                    $select->where(
                        [
                            'cluster.virtual_node_name LIKE ?' => '%' . $condition['virtual_node_name'] . '%'
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());

            return $resultSet->initialize($result);
        }

        return [];
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
        $data['virtual_node_name'] = $dataObject->getVirtualNodeName();
        // creating sub-objects
        // data from the recently persisted objects

        if (empty($data['id'])) {
            $action = new Insert('cluster');
            $action->values($data);
        } else {
            // No UPDATE functionality!
            // $action = new Update('cluster');
            // $action->where(['id' => $data['id']]);
            // unset($data['id']);
            // $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
                if ($dataObject->getServers()) {
                    foreach ($dataObject->getServers() as $server) {
                        if ($server->getName()) {
                            $server->setCluster($dataObject);
                            $this->serverMapper->save($server);
                        }
                    }
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
