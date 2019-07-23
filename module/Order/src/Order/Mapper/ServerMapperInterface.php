<?php
namespace Order\Mapper;

use Base\DataObject\Server;

interface ServerMapperInterface
{

    /**
     * @return Server[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

    /**
     *
     * @param Server $dataObject
     * @return Server
     * @throws \Exception
     */
    public function updateVirtualNodeName(Server $dataObject);

}
