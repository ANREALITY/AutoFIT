<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 */
class Server extends AbstractDataObject
{

    const PLACE_INTERNAL = 'internal';

    const PLACE_EXTERNAL = 'external';

    /**
     * @var string
     */
    private $name;

    /**
     * @var ServerType
     */
    private $serverType;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var string
     */
    private $updated;

    /**
     * @var string
     */
    private $nodeName;

    /**
     * @var string
     */
    private $virtualNodeName;

    /**
     * @var Cluster
     */
    private $cluster;

    /**
     * @var ArrayCollection
     */
    private $endpointServerConfigs;

    public function __construct()
    {
        $this->endpointServerConfigs = new ArrayCollection();
    }

    /**
     * @param string $name
     *
     * @return Server
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ServerType $serverType
     *
     * @return Server
     */
    public function setServerType($serverType)
    {
        $this->serverType = $serverType;

        return $this;
    }

    /**
     * @return ServerType
     */
    public function getServerType()
    {
        return $this->serverType;
    }

    /**
     * @param boolean $active
     *
     * @return Server
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $updated
     *
     * @return Server
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param Cluster $cluster
     *
     * @return Server
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
    }

    /**
     * @return Cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * @param string $nodeName
     *
     * @return Server
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * @param string $virtualNodeName
     *
     * @return Server
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
     * @param ArrayCollection $endpointServerConfigs
     *
     * @return Server
     */
    public function setEndpointServerConfigs($endpointServerConfigs)
    {
        $this->endpointServerConfigs = $endpointServerConfigs;

        return $this;
    }

    /**
     * @return ArrayCollection $endpointServerConfigs
     */
    public function getEndpointServerConfigs()
    {
        return $this->endpointServerConfigs;
    }

    /**
     * @param EndpointServerConfig $endpointServerConfig
     * @return Server
     */
    public function addEndpointServerConfig(EndpointServerConfig $endpointServerConfig)
    {
        $this->endpointServerConfigs->add($endpointServerConfig);
        return $this;
    }

    /**
     * @param EndpointServerConfig $endpointServerConfig
     * @return Server
     */
    public function removeEndpointServerConfig(EndpointServerConfig $endpointServerConfig)
    {
        $this->endpointServerConfigs->removeElement($endpointServerConfig);
        return $this;
    }

}