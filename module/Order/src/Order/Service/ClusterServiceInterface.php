<?php
namespace Order\Service;

use Base\DataObject\Cluster;
use Base\Paginator\Paginator;

interface ClusterServiceInterface
{

    /**
     * @param int $id
     *            Identifier of the Cluster that should be returned
     * @return Cluster
     */
    public function findOne($id);

    /**
     * @param array $criteria
     * @param int $page
     * @return Paginator
     */
    public function findAllPaginated(array $criteria = [], $page = null);

    /**
     * @param string $virtualNodeName
     */
    public function findAllForAutocomplete(string $virtualNodeName);

    /**
     * @param Cluster $clusterRequest
     * @return Cluster
     */
    public function create(Cluster $clusterRequest);

}
