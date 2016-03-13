<?php
namespace Order\Mapper;

use DbSystel\DataObject\Server;

interface ServerMapperInterface
{

    /**
     *
     * @param int|string $name
     * @return Server
     * @throws \InvalidArgumentException
     */
    public function find($name);

    /**
     *
     * @return array|Server[]
     */
    public function findAll();

    /**
     *
     * @param Server $dataObject
     * @return Server
     * @throws \Exception
     */
    public function save(Server $dataObject);
}
