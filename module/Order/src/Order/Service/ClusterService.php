<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\ClusterMapperInterface;
use Base\DataObject\Cluster;

class ClusterService extends AbstractService implements ClusterServiceInterface
{

    /**
     *
     * @var ClusterMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param ClusterMapperInterface $mapper
     */
    public function __construct(ClusterMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllPaginated(array $criteria = [], $page = null)
    {
        return $this->mapper->findAllPaginated($criteria, $page);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAllForAutocomplete(string $virtualNodeName = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'virtual_node_name' => $virtualNodeName
                ]
            ],
            null,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function create(Cluster $cluster)
    {
        return $this->mapper->create($cluster);
    }

}
