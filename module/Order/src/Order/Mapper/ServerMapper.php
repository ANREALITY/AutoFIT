<?php
namespace Order\Mapper;

use DbSystel\DataObject\Server;

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
                if (array_key_exists('name', $condition) && $condition['name']) {
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
                if (array_key_exists('endpoint_type_name', $condition) && $condition['endpoint_type_name']) {
                    $queryBuilder->join('s.serverType', 'set');
                    $queryBuilder->join('set.endpointTypes', 'et');
                    $queryBuilder
                        ->andWhere('et.name = :endpointTypeName')
                        ->setParameter('endpointTypeName', $condition['endpoint_type_name'])
                    ;
                    $queryBuilder->distinct();
                }
                if (array_key_exists('having_cluster', $condition)) {
                    $queryBuilder
                        ->andWhere('s.cluster IS NOT NULL')
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
     * @param Server $dataObject
     *
     * @return Server
     * @throws \Exception
     */
    public function updateVirtualNodeName(Server $dataObject)
    {
        /** @var Server $currentServer */
        $currentServer = $this->entityManager->getRepository(Server::class)->find(
            $dataObject->getName()
        );

        if ($currentServer) {
            $currentServer->setVirtualNodeName($dataObject->getVirtualNodeName());
            $this->entityManager->persist($currentServer);
            $this->entityManager->flush();
        }

        return $dataObject;
    }

}
