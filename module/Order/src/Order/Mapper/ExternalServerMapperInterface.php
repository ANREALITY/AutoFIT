<?php
namespace Order\Mapper;

use DbSystel\DataObject\ExternalServer;

interface ExternalServerMapperInterface
{

    /**
     *
     * @param ExternalServer $dataObject
     * @return ExternalServer
     * @throws \Exception
     */
    public function save(ExternalServer $dataObject);

    /**
     *
     * @param int $endpointId
     * @throws \Exception
     */
    public function deleteOneByEndpointId(int $endpointId);

}
