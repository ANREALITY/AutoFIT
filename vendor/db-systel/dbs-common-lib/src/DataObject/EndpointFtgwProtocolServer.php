<?php
namespace DbSystel\DataObject;

/**
 * Class EndpointFtgwProtocolServer
 *
 * @package DbSystel\DataObject
 */
class EndpointFtgwProtocolServer extends AbstractEndpoint
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
    private $port;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $dnsAddress;

    /**
     * @var IncludeParameterSet
     */
    private $includeParameterSet;

    /**
     * @var ProtocolSet
     */
    private $protocolSet;

    /**
     * @param string $username
     * @return EndpointFtgwProtocolServer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $folder
     * @return EndpointFtgwProtocolServer
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @return string $folder
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $transmissionType
     * @return EndpointFtgwProtocolServer
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    /**
     * @return string $transmissionType
     */
    public function getTransmissionType()
    {
        return $this->transmissionType;
    }

    /**
     * @param string $port
     * @return EndpointFtgwProtocolServer
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $ip
     * @return EndpointFtgwProtocolServer
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $dnsAddress
     * @return EndpointFtgwProtocolServer
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;

        return $this;
    }

    /**
     * @return string $dnsAddress
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     * @param IncludeParameterSet $includeParameterSet
     * @return EndpointFtgwProtocolServer
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
     * @param ProtocolSet $protocolSet
     * @return EndpointFtgwProtocolServer
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}
