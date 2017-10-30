<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;

interface ClusterMapperInterface
{

    /**
     * @return Cluster[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

    /**
     *
     * @param Cluster $dataObject
     * @return Cluster
     * @throws \Exception
     */
    public function create(Cluster $dataObject);

}
