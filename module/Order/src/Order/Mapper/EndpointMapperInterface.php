<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;

interface EndpointMapperInterface
{

    /**
     *
     * @param AbstractEndpoint $dataObject
     * @return AbstractEndpoint
     * @throws \Exception
     */
    public function save(AbstractEndpoint $dataObject);

}
