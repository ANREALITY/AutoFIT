<?php
namespace DbSystel\DataObject;

class EndpointCdLinuxUnix extends AbstractEndpoint
{

    const TRANSMISSION_TYPE_TXT = 'txt';

    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     *
     * @var string
     */
    protected $username;

    /**
     *
     * @var string
     */
    protected $folder;

    /**
     *
     * @var string
     */
    protected $transmissionType;

    /**
     *
     * @var string
     */
    protected $transmissionInterval;

    /**
     *
     * @var string
     */
    protected $cluster;

    /**
     *
     * @var string
     */
    protected $serviceAddress;

    /**
     *
     * @var IncludeParameterSet
     */
    protected $includeParameterSet;

    /**
     *
     * @var Server[]
     */
    protected $servers;

    /**
     *
     * @var ExternalServer[]
     */
    protected $externalServers;

    /**
     *
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @return the $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     *
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }

    /**
     *
     * @return the $transmissionType
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     *
     * @param string $transmissionType
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;
    }

    /**
     *
     * @return the $transmissionInterval
     */
    public function getTransmissionInterval()
    {
        return $this->transmissionInterval;
    }

    /**
     *
     * @param string $transmissionInterval
     */
    public function setTransmissionInterval($transmissionInterval)
    {
        $this->transmissionInterval = $transmissionInterval;
    }

    /**
     *
     * @return the $cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     *
     * @param string $cluster
     */
    public function setCluster($cluster)
    {
        $this->cluster = $cluster;
    }

    /**
     *
     * @return the $serviceAddress
     */
    public function getServiceAddress()
    {
        return $this->serviceAddress;
    }

    /**
     *
     * @param string $serviceAddress
     */
    public function setServiceAddress($serviceAddress)
    {
        $this->serviceAddress = $serviceAddress;
    }

    /**
     *
     * @return the $includeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

    /**
     *
     * @param IncludeParameterSet $includeParameterSet
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;
    }

    /**
     *
     * @return the $servers
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     *
     * @param multitype:Server $servers
     */
    public function setServers(array $servers)
    {
        $this->servers = $servers;
    }

    /**
     * @return the $externalServers
     */
    public function getExternalServers()
    {
        return $this->externalServers;
    }

    /**
     * @param multitype:ExternalServer $externalServers
     */
    public function setExternalServers(array $externalServers)
    {
        $this->externalServers = $externalServers;
    }

}
