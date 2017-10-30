<?php
namespace Order\Mapper;

use DbSystel\DataObject\ExternalServer;

interface ExternalServerMapperInterface
{

    /**
     *
     * @param int $endpointId
     * @throws \Exception
     */
    public function deleteOneByEndpointId(int $endpointId);

}
