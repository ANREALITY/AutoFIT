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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

        return $this;
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

        return $this;
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