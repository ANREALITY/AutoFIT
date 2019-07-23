<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dns_address", type="string", length=253, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $dnsAddress;

    /**
     * @var Cluster
     *
     * @ORM\ManyToOne(targetEntity="Cluster", inversedBy="endpointClusterConfigs", cascade={"persist"})
     *
     * @Groups({"export"})
     */
    protected $cluster;

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
