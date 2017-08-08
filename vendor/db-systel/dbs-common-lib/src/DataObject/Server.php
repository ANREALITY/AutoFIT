<?php
namespace DbSystel\DataObject;

class Server extends AbstractDataObject
{

    const PLACE_INTERNAL = 'internal';

    const PLACE_EXTERNAL = 'external';

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var ServerType
     */
    protected $serverType;

    /**
     *
     * @var boolean
     */
    protected $active;

    /**
     *
     * @var string
     */
    protected $nodeName;

    /**
     *
     * @var string
     */
    protected $virtualNodeName;

    /**
     *
     * @var Cluster
     */
    protected $cluster;

    /**
     *
     * @var EndpointServerConfig[]
     */
    protected $endpointServerConfigs;

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return ServerType $serverType
     */
    public function getServerType()
    {
        return $this->serverType;
    }

    /**
     *
     * @param ServerType $serverType
     */
    public function setServerType($serverType)
    {
        $this->serverType = $serverType;
    }

    /**
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     *
     * @return Cluster $cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     *
     * @param Cluster $cluster
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;
    }

    /**
     *
     * @return string $nodeName
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     *
     * @param string $nodeName
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
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
     * @return EndpointServerConfig[] $endpointServerConfigs
     */
    public function getEndpointServerConfigs()
    {
        return $this->endpointServerConfigs;
    }

    /**
     *
     * @param multitype:EndpointServerConfig $endpointServerConfigs
     */
    public function setEndpointServerConfigs(array $endpointServerConfigs)
    {
        $this->endpointServerConfigs = $endpointServerConfigs;
    }

}