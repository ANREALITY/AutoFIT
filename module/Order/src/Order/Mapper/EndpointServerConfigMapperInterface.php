<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointServerConfig;

interface EndpointServerConfigMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return EndpointServerConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($name);

    /**
     *
     * @return array|EndpointServerConfig[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param EndpointServerConfig $dataObject
     * @return EndpointServerConfig
     * @throws \Exception
     */
    public function save(EndpointServerConfig $dataObject);

}
