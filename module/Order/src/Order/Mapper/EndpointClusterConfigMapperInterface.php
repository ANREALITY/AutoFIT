<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointClusterConfig;

interface EndpointClusterConfigMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return EndpointClusterConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($name);

    /**
     *
     * @return array|EndpointClusterConfig[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param EndpointClusterConfig $dataObject
     * @return EndpointClusterConfig
     * @throws \Exception
     */
    public function save(EndpointClusterConfig $dataObject);

}
