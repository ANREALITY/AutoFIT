<?php
namespace Order\Mapper;

use Base\DataObject\Cluster;
use Base\Paginator\Paginator;

interface ClusterMapperInterface
{

    /**
     * @return Cluster[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

    /**
     * @param array $criteria
     * @param int $page
     * @return Paginator
     */
    public function findAllPaginated(array $criteria = [], $page = null);

    /**
     *
     * @param Cluster $dataObject
     * @return Cluster
     * @throws \Exception
     */
    public function create(Cluster $dataObject);

}
