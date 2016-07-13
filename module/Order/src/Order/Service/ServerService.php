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
    public function findAllForAutocomplete(string $name, string $endpointTypeName = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'name' => $name,
                    'active' => true,
                    'endpoint_type_name' => $endpointTypeName
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(Server $server)
    {
        return $this->mapper->save($server);
    }

}
