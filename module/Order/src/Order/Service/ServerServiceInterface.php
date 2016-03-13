<?php
namespace Order\Service;

use DbSystel\DataObject\Server;

interface ServerServiceInterface
{

    /**
     *
     * @return array|Server[]
     */
    public function findAllServers();

    /**
     *
     * @param int $id
     *            Identifier of the Server that should be returned
     * @return Server
     */
    public function findServer($id);

    /**
     *
     * @param Server $server
     * @return Server
     */
    public function saveServer(Server $serverRequest);
}
