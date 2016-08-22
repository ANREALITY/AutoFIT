<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointClusterConfig;
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

class EndpointClusterConfigMapper extends AbstractMapper implements EndpointClusterConfigMapperInterface
{

    /**
     *
     * @var EndpointClusterConfig
     */
    protected $prototype;

    /**
     *
     * @var ClusterMapperInterface
     */
    protected $clusterMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, EndpointClusterConfig $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param ClusterMapperInterface $clusterMapper
     */
    public function setClusterMapper(ClusterMapperInterface $clusterMapper)
    {
        $this->clusterMapper = $clusterMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return EndpointClusterConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|EndpointClusterConfig[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_cluster_config');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('id', $condition)) {
                    $select->where(
                        [
                            'id = ?' => $condition['id']
                        ]);
                }
                if (array_key_exists('dns_address', $condition)) {
                    $select->where(
                        [
                            'endpoint_cluster_config.dns_address LIKE ?' => '%' . $condition['dns_address'] . '%'
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
     * @param EndpointClusterConfig $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return EndpointClusterConfig
     * @throws \Exception
     */
    public function save(EndpointClusterConfig $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['dns_address'] = $dataObject->getDnsAddress() ?: new Expression('NULL');
        $data['cluster_id'] = $dataObject->getCluster()->getId() ?: new Expression('NULL');
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if (! empty($data['id']) && $updateIfIdSet) {
            $action = new Update('endpoint_cluster_config');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('endpoint_cluster_config');
            $action->values($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier, $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        $cdLinuxUnixClusterDataObjects = $this->clusterMapper->createDataObjects($resultSetArray,
            null, null, ['id', 'id'], ['cd_linux_unix_cluster__', 'cd_linux_unix_cluster_config__'], 'id', 'cd_linux_unix_cluster_config__', null,
            null, false);

        foreach ($dataObjects as $key => $dataObject) {
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $cdLinuxUnixClusterDataObjects,
                'setCluster', 'getId');
        }

        return $dataObjects;
    }

}
