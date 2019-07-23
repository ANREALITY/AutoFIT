<?php
namespace Base\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="virtual_node_name", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $virtualNodeName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Server", mappedBy="cluster")
     *
     * @Groups({"export"})
     */
    protected $servers;

    /**
     * @var AbstractEndpoint[]
     */
    protected $endpoints;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="EndpointClusterConfig", mappedBy="cluster")
     */
    protected $endpointClusterConfigs;

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
     * @param ArrayCollection $servers
     *
     * @return Cluster
     */
    public function setServers($servers)
    {
        $this->removeServersNotInList($servers);
        $this->servers = new ArrayCollection([]);
        /** @var Server $server */
        foreach ($servers as $server) {
            $this->addServer($server);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $servers
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
        $server->setCluster($this);
        return $this;
    }

    /**
     * @param Server $server
     * @return Cluster
     */
    public function removeServer(Server $server)
    {
        $this->servers->removeElement($server);
        $server->setCluster(null);
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

    /**
     * @param $servers
     * @return void
     */
    private function removeServersNotInList($servers)
    {
        if (is_array($servers)) {
            $servers = new ArrayCollection($servers);
        }
        foreach ($this->getServers() as $server) {
            if ($servers->indexOf($server) === false) {
                $this->removeServer($server);
            }
        }
    }

}