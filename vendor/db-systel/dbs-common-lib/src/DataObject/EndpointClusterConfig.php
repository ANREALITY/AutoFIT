<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointClusterConfig
 */
class EndpointClusterConfig extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $dnsAddress;

    /**
     * @var Cluster
     */
    private $cluster;

    /**
     * @param integer $id
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
     * @return EndpointClusterConfig
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

}