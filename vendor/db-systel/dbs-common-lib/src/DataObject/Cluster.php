<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cluster
 *
 * @ORM\Table(
 *     name="cluster",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="virtual_node_name_UNIQUE", columns={"virtual_node_name"})
 *     }
 * )
 * @ORM\Entity
 */
class Cluster extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="virtual_node_name", type="string", length=50, nullable=true)
     */
    private $virtualNodeName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Server", mappedBy="cluster")
     */
    private $servers;

    /**
     * @var AbstractEndpoint[]
     */
    private $endpoints;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="EndpointClusterConfig", mappedBy="cluster")
     */
    private $endpointClusterConfigs;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
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
     * @param AbstractEndpoint[] $servers
     *
     * @return Cluster
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;

        return $this;
    }

    /**
     * @return Server[] $servers
     */
    public function getServers()
    {
        return $this->servers; // ->toArray()
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
     * @param AbstractEndpoint[] $endpoints
     *
     * @return Cluster
     */
    public function setEndpoints(array $endpoints)
    {
        $this->endpoints = $endpoints;

        return $this;
    }

    /**
     * @return AbstractEndpoint[] $endpoints
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param EndpointClusterConfig[] $endpointClusterConfigs
     *
     * @return Cluster
     */
    public function setEndpointClusterConfigs(array $endpointClusterConfigs)
    {
        $this->endpointClusterConfigs = $endpointClusterConfigs;

        return $this;
    }

    /**
     * @return EndpointClusterConfig[] $endpointClusterConfigs
     */
    public function getEndpointClusterConfigs()
    {
        return $this->endpointClusterConfigs; // ->toArray()
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