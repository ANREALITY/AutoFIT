<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
use DbSystel\DataObject\Server;
use Doctrine\Common\Collections\ArrayCollection;

class ClusterMapper extends AbstractMapper implements ClusterMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Cluster::class;

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
    public function create(Cluster $dataObject)
    {
        if (! $dataObject->getId()) {
            $servers = [];
            foreach ($dataObject->getServers() as $server) {
                /** @var Server $currentServer */
                $currentServer = $this->entityManager->getRepository(Server::class)->find(
                    $server->getName()
                );
                if ($currentServer) {
                    $servers[] = $currentServer;
                }
            }
            $dataObject->setServers(new ArrayCollection($servers));
            $this->entityManager->persist($dataObject);
            $this->entityManager->flush();
        }

        return $dataObject;
    }

}
