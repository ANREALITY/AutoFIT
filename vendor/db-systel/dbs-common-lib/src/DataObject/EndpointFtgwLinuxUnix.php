<?php
namespace DbSystel\DataObject;

class EndpointFtgwLinuxUnix extends AbstractEndpoint
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
    protected $fetchInterval;

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
     * @var EndpointClusterConfig
     */
    protected $endpointClusterConfig;

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
     * @return the $fetchInterval
     */
    public function getFetchInterval()
    {
        return $this->fetchInterval;
    }

    /**
     *
     * @param string $fetchInterval
     */
    public function setFetchInterval($fetchInterval)
    {
        $this->fetchInterval = $fetchInterval;
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
     * @return the $endpointClusterConfig
     */
    public function getEndpointClusterConfig()
    {
        return $this->endpointClusterConfig;
    }

    /**
     *
     * @param EndpointClusterConfig $endpointClusterConfig
     */
    public function setEndpointClusterConfig(EndpointClusterConfig $endpointClusterConfig)
    {
        $this->endpointClusterConfig = $endpointClusterConfig;
    }

}
