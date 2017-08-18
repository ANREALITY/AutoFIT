<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(name="server", indexes={@ORM\Index(name="fk_server_server_type_idx", columns={"server_type_id"}), @ORM\Index(name="fk_server_cluster_idx", columns={"cluster_id"})})
 * @ORM\Entity
 */
class Server
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
     * @var \Cluster
     *
     * @ORM\ManyToOne(targetEntity="Cluster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cluster_id", referencedColumnName="id")
     * })
     */
    private $cluster;

    /**
     * @var \ServerType
     *
     * @ORM\ManyToOne(targetEntity="ServerType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_type_id", referencedColumnName="id")
     * })
     */
    private $serverType;



    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
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
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set updated
     *
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
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set nodeName
     *
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
     * Get nodeName
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * Set virtualNodeName
     *
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
     * Get virtualNodeName
     *
     * @return string
     */
    public function getVirtualNodeName()
    {
        return $this->virtualNodeName;
    }

    /**
     * Set cluster
     *
     * @param \Cluster $cluster
     *
     * @return Server
     */
    public function setCluster(\Cluster $cluster = null)
    {
        $this->cluster = $cluster;

        return $this;
    }

    /**
     * Get cluster
     *
     * @return \Cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * Set serverType
     *
     * @param \ServerType $serverType
     *
     * @return Server
     */
    public function setServerType(\ServerType $serverType = null)
    {
        $this->serverType = $serverType;

        return $this;
    }

    /**
     * Get serverType
     *
     * @return \ServerType
     */
    public function getServerType()
    {
        return $this->serverType;
    }
}
