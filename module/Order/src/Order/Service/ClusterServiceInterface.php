<?php
namespace Order\Service;

use DbSystel\DataObject\Cluster;

interface ClusterServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the Cluster that should be returned
     * @return Cluster
     */
    public function findOne($id);

    /**
     *
     * @param string $virtualNodeName
     */
    public function findAllForAutocomplete(string $virtualNodeName);

    /**
     *
     * @param Cluster $cluster
     * @return Cluster
     */
    public function create(Cluster $clusterRequest);

}
