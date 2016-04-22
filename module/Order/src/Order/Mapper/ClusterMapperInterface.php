<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;

interface ClusterMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return Cluster
     * @throws \InvalidArgumentException
     */
    public function find($name);

    /**
     *
     * @return array|Cluster[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Cluster $dataObject
     * @return Cluster
     * @throws \Exception
     */
    public function save(Cluster $dataObject);

}
