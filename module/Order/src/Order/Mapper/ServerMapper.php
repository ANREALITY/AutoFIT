<?php
namespace Order\Mapper;

use DbSystel\DataObject\Server;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class ServerMapper extends AbstractMapper implements ServerMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Server::class;

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(static::ENTITY_TYPE, 's');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('name', $condition)) {
                    $queryBuilder
                        ->andWhere('s.name LIKE :name')
                        ->setParameter('name', '%' . $condition['name'] . '%')
                    ;
                }
                if (array_key_exists('active', $condition)) {
                    $queryBuilder
                        ->andWhere('s.active LIKE :active')
                        ->setParameter('active', '%' . $condition['active'] . '%')
                    ;
                }
                if (array_key_exists('node_name', $condition)) {
                    $queryBuilder
                        ->andWhere('s.nodeName IS NULL')
                    ;
                }
                if (array_key_exists('virtual_node_name', $condition)) {
                    $queryBuilder
                        ->andWhere('s.virtualNodeName IS NULL')
                    ;
                }
                if (array_key_exists('cluster_id', $condition)) {
                    if ($condition['cluster_id'] === null) {
                        $queryBuilder
                            ->andWhere('s.cluster IS NULL')
                        ;
                    }
                }
                if (array_key_exists('endpoint_type_name', $condition)) {
                    $queryBuilder->join('s.serverType', 'set');
                    $queryBuilder->join('set.endpointTypes', 'et');
                    $queryBuilder
                        ->andWhere('et.name = :endpointTypeName')
                        ->setParameter('endpointTypeName', $condition['endpoint_type_name'])
                    ;
                    $queryBuilder->distinct();
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
     * @param Server $dataObject
     *
     * @return Server
     * @throws \Exception
     */
    public function save(Server $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['name'] = $dataObject->getName();
        $data['virtual_node_name'] = $dataObject->getVirtualNodeName();
        $data['cluster_id'] = $dataObject->getCluster() && $dataObject->getCluster()->getId() ? $dataObject->getCluster()->getId() : new Expression('NULL');
        // creating sub-objects
        // data from the recently persisted objects

        if (empty($data['name'])) {
            // No INSERT functionality!
            // $action = new Insert('server');
            // $action->values($data);
        } else {
            $action = new Update('server');
            $action->where(['name' => $data['name']]);
            unset($data['name']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newName = $result->getGeneratedValue() ?: $dataObject->getName();
            if ($newName) {
                $dataObject->setName($newName);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
