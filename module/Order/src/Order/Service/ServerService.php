<?php
namespace Order\Service;

use Order\Mapper\ServerMapperInterface;
use DbSystel\DataObject\Server;

class ServerService extends AbstractService implements ServerServiceInterface
{

    /**
     *
     * @var ServerMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param ServerMapperInterface $mapper
     */
    public function __construct(ServerMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->mapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findServer($id)
    {
        return $this->mapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveServer(Server $server)
    {
        return $this->mapper->save($server);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllByName(string $name)
    {
        return $this->mapper->findAll(
            [
                [
                    'name' => $name
                ]
            ]);
    }

}
