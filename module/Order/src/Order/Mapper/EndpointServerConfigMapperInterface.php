<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointServerConfig;

interface EndpointServerConfigMapperInterface
{

    /**
     *
     * @param EndpointServerConfig $dataObject
     * @return EndpointServerConfig
     * @throws \Exception
     */
    public function save(EndpointServerConfig $dataObject);

}
