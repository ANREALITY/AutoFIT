<?php
namespace DbSystel\DataObject;

/**
 * EndpointCdLinuxUnix
 */
class EndpointCdLinuxUnix extends AbstractEndpoint
{

    const TRANSMISSION_TYPE_TXT = 'txt';

    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $folder;

    /**
     * @var string
     */
    private $transmissionType;

    /**
     * @var string
     */
    private $transmissionInterval;

    /**
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     * @var EndpointClusterConfig
     */
    private $endpointClusterConfig;

    /**
     * @param string $username
     * @return EndpointCdLinuxUnix
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $folder
     * @return EndpointCdLinuxUnix
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $transmissionType
     * @return EndpointCdLinuxUnix
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param string $transmissionInterval
     * @return EndpointCdLinuxUnix
     */
    public function setTransmissionInterval($transmissionInterval)
    {
        $this->transmissionInterval = $transmissionInterval;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransmissionInterval()
    {
        return $this->transmissionInterval;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     * @return EndpointCdLinuxUnix
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * @return IncludeParameterSet $includeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

    /**
     * @param EndpointClusterConfig $endpointClusterConfig
     * @return EndpointCdLinuxUnix
     */
    public function setEndpointClusterConfig(EndpointClusterConfig $endpointClusterConfig)
    {
        $this->endpointClusterConfig = $endpointClusterConfig;

        return $this;
    }

    /**
     * @return EndpointClusterConfig $endpointClusterConfig
     */
    public function getEndpointClusterConfig()
    {
        return $this->endpointClusterConfig;
    }

}
