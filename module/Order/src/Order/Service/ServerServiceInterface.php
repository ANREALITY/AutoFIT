<?php
namespace Order\Service;

use Base\DataObject\Server;

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
     * @param string $endpointTypeName
     */
    public function findAllForAutocomplete(string $name, string $endpointTypeName = null);

    /**
     * @param string $name
     * @return Server[]
     */
    public function findAllHavingClusterForAutocomplete(string $name);

    /**
     *
     * @param Server $server
     * @return Server
     */
    public function updateVirtualNodeName(Server $serverRequest);

    /**
     *
     * @param string $name
     * @return Server[]
     */
    public function findAllInUseForAutocomplete(string $name);

}
