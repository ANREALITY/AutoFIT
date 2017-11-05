<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
use DbSystel\DataObject\Server;
use DbSystel\Paginator\Paginator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;

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
     * @inheritdoc
     */
    public function findAllPaginated(array $criteria = [], $page = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c')->from(static::ENTITY_TYPE, 'c');

        foreach ($criteria as $key => $condition) {
            if ($key === 'virtual_node_name') {
                $queryBuilder
                    ->andWhere('c.virtualNodeName = :virtualNodeName')
                    ->setParameter('virtualNodeName', $condition);
            }
            if ($key === 'server_name') {
                $queryBuilder->join('c.servers', 's');
                $queryBuilder
                    ->andWhere('s.name = :serverName')
                    ->setParameter('serverName', $condition);
            }
        }

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator(new PaginatorAdapter(new ORMPaginator($query)));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($this->itemCountPerPage);

        return $paginator;
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
