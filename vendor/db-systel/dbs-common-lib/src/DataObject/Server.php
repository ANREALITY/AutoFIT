<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(
 *     name="server",
 *     indexes={
 *         @ORM\Index(name="fk_server_server_type_idx", columns={"server_type_id"}),
 *         @ORM\Index(name="fk_server_cluster_idx", columns={"cluster_id"})
 *     }
 * )
 * @ORM\Entity(readOnly=true)
 */
class Server extends AbstractDataObject
{

    /** @var string */
    const PLACE_INTERNAL = 'internal';
    /** @var string */
    const PLACE_EXTERNAL = 'external';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var ServerType
     *
     * @ORM\ManyToOne(targetEntity="ServerType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_type_id", referencedColumnName="id")
     * })
     */
    private $serverType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="node_name", type="string", length=50, nullable=true)
     */
    private $nodeName;

    /**
     * @var string
     *
     * @ORM\Column(name="virtual_node_name", type="string", length=50, nullable=true)
     */
    private $virtualNodeName;

    /**
     * @var Cluster
     *
     * @ORM\ManyToOne(targetEntity="Cluster", inversedBy="servers")
     */
    private $cluster;

    /**
     * @var EndpointServerConfig[]
     */
    private $endpointServerConfigs;

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
     * @param \DateTime $updated
     *
     * @return Server
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return \DateTime
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
    public function setCluster(Cluster $cluster = null)
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
     * @param EndpointServerConfig[] $endpointServerConfigs
     *
     * @return Server
     */
    public function setEndpointServerConfigs($endpointServerConfigs)
    {
        $this->endpointServerConfigs = $endpointServerConfigs;
        return $this;
    }

    /**
     * @return EndpointServerConfig[] $endpointServerConfigs
     */
    public function getEndpointServerConfigs()
    {
        return $this->endpointServerConfigs;
    }

}
