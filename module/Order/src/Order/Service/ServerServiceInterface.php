<?php
namespace Order\Service;

use DbSystel\DataObject\Server;

interface ServerServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the Server that should be returned
     * @return Server
     */
    public function findOne($id);

    /**
     *
     * @param string $name            
     */
    public function findAllByName(string $name);

    /**
     *
     * @param Server $server            
     * @return Server
     */
    public function saveOne(Server $serverRequest);

}
