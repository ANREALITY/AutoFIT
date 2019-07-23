<?php
namespace Order\Service;

use Base\DataObject\Server;
use Doctrine\ORM\Query;
use Order\Mapper\ServerMapperInterface;

class ServerService extends AbstractService implements ServerServiceInterface
{

    const LIMIT_AUTOCOMPLETE = 25;

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
            ],
            self::LIMIT_AUTOCOMPLETE,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllNotInCdUseForAutocomplete(string $name)
    {
        return $this->mapper->findAll(
            [
                [
                    'name' => $name,
                    'active' => true,
                    'node_name' => null,
                    'virtual_node_name' => null,
                    'cluster_id' => null
                ]
            ],
            self::LIMIT_AUTOCOMPLETE,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllNotInClusterForAutocomplete(string $name)
    {
        return $this->mapper->findAll(
            [
                [
                    'name' => $name,
                    'active' => true,
                    'node_name' => null,
                    'virtual_node_name' => null,
                    'cluster_id' => null
                ]
            ],
            self::LIMIT_AUTOCOMPLETE,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllHavingClusterForAutocomplete(string $name)
    {
        $criteria = [];
        $criteria[] = ['active' => true];
        $criteria[] = ['having_cluster' => true];
        if ($name) {
            $criteria[] = ['name' => $name];
        }
        return $this->mapper->findAll(
            $criteria,
            self::LIMIT_AUTOCOMPLETE,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function updateVirtualNodeName(Server $server)
    {
        return $this->mapper->updateVirtualNodeName($server);
    }


    /**
     *
     * @param string $name
     * @return Server[]
     */
    public function findAllInUseForAutocomplete(string $name)
    {
        return $this->mapper->findAll(
            [
                [
                    'name' => $name,
                    'active' => true,
                    'is_in_use' => true
                ]
            ],
            self::LIMIT_AUTOCOMPLETE,
            Query::HYDRATE_ARRAY
        );
    }

}
