<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointClusterConfig
 *
 * @ORM\Table(name="endpoint_cluster_config", indexes={@ORM\Index(name="fk_endpoint_cluster_config_cluster_idx", columns={"cluster_id"})})
 * @ORM\Entity
 */
class EndpointClusterConfig extends AbstractDataObject
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
     * @ORM\Column(name="dns_address", type="string", length=253, nullable=true)
     */
    private $dnsAddress;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dnsAddress
     *
     * @param string $dnsAddress
     *
     * @return EndpointClusterConfig
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;

        return $this;
    }

    /**
     * Get dnsAddress
     *
     * @return string
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     * Set cluster
     *
     * @param \Cluster $cluster
     *
     * @return EndpointClusterConfig
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
}
