<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;

class ClusterMapper extends AbstractMapper implements ClusterMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Cluster::class;

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
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c')->from(static::ENTITY_TYPE, 'c');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('virtual_node_name', $condition)) {
                    $queryBuilder
                        ->andWhere('c.virtualNodeName LIKE :virtualNodeName')
                        ->setParameter('virtualNodeName', '%' . $condition['virtual_node_name'] . '%')
                    ;
                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
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
