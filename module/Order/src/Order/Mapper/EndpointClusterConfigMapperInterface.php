<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointClusterConfig;

interface EndpointClusterConfigMapperInterface
{

    /**
     *
     * @param EndpointClusterConfig $dataObject
     * @return EndpointClusterConfig
     * @throws \Exception
     */
    public function save(EndpointClusterConfig $dataObject);

}
