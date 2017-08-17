<?php
namespace DbSystel\DataObject;

class Cluster extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $virtualNodeName;

    /**
     *
     * @var Server[]
     */
    protected $servers;

    /**
     *
     * @var AbstractEndpoint[]
     */
    protected $endpoints;

    /**
     *
     * @var EndpointClusterConfig[]
     */
    protected $endpointClusterConfigs;

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $virtualNodeName
     */
    public function setVirtualNodeName($virtualNodeName)
    {
        $this->virtualNodeName = $virtualNodeName;

        return $this;
    }

    /**
     *
     * @return string $virtualNodeName
     */
    public function getVirtualNodeName()
    {
        return $this->virtualNodeName;
    }

    /**
     *
     * @param multitype:Server $servers
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;

        return $this;
    }

    /**
     *
     * @return Server[] $servers
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     *
     * @param multitype:AbstractEndpoint $endpoints
     */
    public function setEndpoints(array $endpoints)
    {
        $this->endpoints = $endpoints;

        return $this;
    }

    /**
     *
     * @return AbstractEndpoint[] $endpoints
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     *
     * @param multitype:EndpointClusterConfig $endpointClusterConfigs
     */
    public function setEndpointClusterConfigs(array $endpointClusterConfigs)
    {
        $this->endpointClusterConfigs = $endpointClusterConfigs;

        return $this;
    }

    /**
     *
     * @return EndpointClusterConfig[] $endpointClusterConfigs
     */
    public function getEndpointClusterConfigs()
    {
        return $this->endpointClusterConfigs;
    }

}