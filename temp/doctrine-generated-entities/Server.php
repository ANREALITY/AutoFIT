<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(name="server", indexes={@ORM\Index(name="fk_server_server_type_idx", columns={"server_type_id"}), @ORM\Index(name="fk_server_cluster_idx", columns={"cluster_id"})})
 * @ORM\Entity
 */
class Server extends AbstractDataObject
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = '0';

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
     * @ORM\ManyToOne(targetEntity="Cluster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cluster_id", referencedColumnName="id")
     * })
     */
    private $cluster;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param ServerType $serverType
     *
     * @return Server
     */
    public function setServerType(ServerType $serverType = null)
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

}
