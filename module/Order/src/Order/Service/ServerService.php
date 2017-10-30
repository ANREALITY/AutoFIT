<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\ServerMapperInterface;
use DbSystel\DataObject\Server;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Where;

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
    public function updateVirtualNodeName(Server $server)
    {
        return $this->mapper->updateVirtualNodeName($server);
    }

}
