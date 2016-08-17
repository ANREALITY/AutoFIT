<?php
namespace Order\Service;

use Order\Mapper\ClusterMapperInterface;
use DbSystel\DataObject\Cluster;

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
    public function findAllForAutocomplete(string $virtualNodeName = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'virtual_node_name' => $virtualNodeName
                ]
            ]);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(Cluster $cluster)
    {
        return $this->mapper->save($cluster);
    }

}
