<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointClusterConfig
 *
 * @ORM\Table(
 *     name="endpoint_cluster_config",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_cluster_config_cluster_idx", columns={"cluster_id"})
 *     }
 * )
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
     */
    private $dnsAddress;

    /**
     * @var Cluster
     *
     * @ORM\ManyToOne(targetEntity="Cluster", inversedBy="endpointClusterConfigs")
     */
    private $cluster;

    /**
     * @param integer $id
     *
     * @return EndpointClusterConfig
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
     * @return string
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     * @param Cluster $cluster
     *
     * @return EndpointClusterConfig
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

}
