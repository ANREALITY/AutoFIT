<?php
namespace Order\Service;

use Order\Mapper\ServerMapperInterface;
use DbSystel\DataObject\Server;

class ServerService implements ServerServiceInterface
{

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    /**
     *
     * @param ServerMapperInterface $serverMapper
     */
    public function __construct(ServerMapperInterface $serverMapper)
    {
        $this->serverMapper = $serverMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllServers()
    {
        return $this->serverMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findServer($id)
    {
        return $this->serverMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveServer(Server $server)
    {
        return $this->serverMapper->save($server);
    }
}
