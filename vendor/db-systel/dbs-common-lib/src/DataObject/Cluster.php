<?php
namespace DbSystel\DataObject;

class Cluster extends AbstractDataObject
{

    /**
     *
     * @var int
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
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $virtualNodeName
     */
    public function setVirtualNodeName($virtualNodeName)
    {
        $this->virtualNodeName = $virtualNodeName;
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
     * @param multitype:Server $servers
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;
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
     * @param multitype:AbstractEndpoint $endpoints
     */
    public function setEndpoints(array $endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     *
     * @return EndpointClusterConfig[] $endpointClusterConfigs
     */
    public function getEndpointClusterConfigs()
    {
        return $this->endpointClusterConfigs;
    }

    /**
     *
     * @param multitype:EndpointClusterConfig $endpointClusterConfigs
     */
    public function setEndpointClusterConfigs(array $endpointClusterConfigs)
    {
        $this->endpointClusterConfigs = $endpointClusterConfigs;
    }

}