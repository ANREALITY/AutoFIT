<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cluster
 */
class Cluster extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $virtualNodeName;

    /**
     * @var ArrayCollection
     */
    private $servers;

    /**
     * @var ArrayCollection
     */
    private $endpoints;

    /**
     * @var ArrayCollection
     */
    private $endpointClusterConfigs;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
        $this->endpoints = new ArrayCollection();
        $this->endpointClusterConfigs = new ArrayCollection();
    }

    /**
     * @param int $id
     *
     * @return Cluster
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $virtualNodeName
     *
     * @return Cluster
     */
    public function setVirtualNodeName($virtualNodeName)
    {
        $this->virtualNodeName = $virtualNodeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getVirtualNodeName()
    {
        return $this->virtualNodeName;
    }

    /**
     * @param ArrayCollection $servers
     *
     * @return Cluster
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;

        return $this;
    }

    /**
     * @return ArrayCollection $servers
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * @param Server $server
     * @return Cluster
     */
    public function addServer(Server $server)
    {
        $this->servers->add($server);
        return $this;
    }

    /**
     * @param Server $server
     * @return Cluster
     */
    public function removeServer(Server $server)
    {
        $this->servers->removeElement($server);
        return $this;
    }

    /**
     * @param ArrayCollection $endpoints
     *
     * @return Cluster
     */
    public function setEndpoints(array $endpoints)
    {
        $this->endpoints = $endpoints;

        return $this;
    }

    /**
     * @return ArrayCollection $endpoints
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return Cluster
     */
    public function addEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoints->add($endpoint);
        return $this;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return Cluster
     */
    public function removeEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoints->removeElement($endpoint);
        return $this;
    }

    /**
     * @param ArrayCollection $endpointClusterConfigs
     *
     * @return Cluster
     */
    public function setEndpointClusterConfigs(array $endpointClusterConfigs)
    {
        $this->endpointClusterConfigs = $endpointClusterConfigs;

        return $this;
    }

    /**
     * @return ArrayCollection $endpointClusterConfigs
     */
    public function getEndpointClusterConfigs()
    {
        return $this->endpointClusterConfigs;
    }

    /**
     * @param EndpointClusterConfig $endpointClusterConfig
     * @return Cluster
     */
    public function addEndpointClusterConfig(EndpointClusterConfig $endpointClusterConfig)
    {
        $this->endpointClusterConfigs->add($endpointClusterConfig);
        return $this;
    }

    /**
     * @param EndpointClusterConfig $endpointClusterConfig
     * @return Cluster
     */
    public function removeEndpointClusterConfig(EndpointClusterConfig $endpointClusterConfig)
    {
        $this->endpointClusterConfigs->removeElement($endpointClusterConfig);
        return $this;
    }

}