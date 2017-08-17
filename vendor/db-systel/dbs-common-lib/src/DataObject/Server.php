<?php
namespace DbSystel\DataObject;

/**
 * Class Server
 *
 * @package DbSystel\DataObject
 */
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
     * @param string $name
     * @return Server
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

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
     * @param ServerType $serverType
     * @return Server
     */
    public function setServerType($serverType)
    {
        $this->serverType = $serverType;

        return $this;
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
     * @param boolean $active
     * @return Server
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
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
     * @param Cluster $cluster
     * @return Server
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
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
     * @param string $nodeName
     * @return Server
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;

        return $this;
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
     * @param string $virtualNodeName
     * @return Server
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
     * @param EndpointServerConfig[] $endpointServerConfigs
     * @return Server
     */
    public function setEndpointServerConfigs(array $endpointServerConfigs)
    {
        $this->endpointServerConfigs = $endpointServerConfigs;

        return $this;
    }

    /**
     *
     * @return EndpointServerConfig[] $endpointServerConfigs
     */
    public function getEndpointServerConfigs()
    {
        return $this->endpointServerConfigs;
    }

}