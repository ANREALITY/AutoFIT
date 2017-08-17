<?php
namespace DbSystel\DataObject;

class EndpointClusterConfig extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $dnsAddress;

    /**
     *
     * @var Cluster
     */
    protected $cluster;

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $dnsAddress
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;
    }

    /**
     *
     * @return string $dnsAddress
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     *
     * @param Cluster $cluster
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;
    }

    /**
     *
     * @return Cluster $cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

}