<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
use Doctrine\ORM\EntityManager;
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
use DbSystel\DataObject\AbstractEndpoint;

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

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, $parentIdentifier, $parentPrefix, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        $cdLinuxUnixServerDataObjects = $this->serverMapper->createDataObjects($resultSetArray,
            'id', 'cd_linux_unix_cluster__', 'name', 'cd_linux_unix_server__', null, null, null,
            function (array $row) {
                $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_LINUX_UNIX;
                $serverExists = array_key_exists('cd_linux_unix_server' . '__' . 'name', $row) && !empty($row['cd_linux_unix_server' . '__' . 'name']);
                return $typeIsOk && $serverExists;
            }, true);
    
        foreach ($dataObjects as $key => $dataObject) {
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $cdLinuxUnixServerDataObjects,
                'setServers', 'getId');
        }

        if (!empty($cdLinuxUnixServerDataObjects)) {
            $breakboint = null;
        }

        return $dataObjects;
    }

}
