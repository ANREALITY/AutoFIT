<?php
namespace DbSystel\DataObject;

class EndpointFtgwProtocolServer extends AbstractEndpoint
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
    protected $port;

    /**
     *
     * @var string
     */
    protected $ip;

    /**
     *
     * @var string
     */
    protected $dnsAddress;

    /**
     *
     * @var IncludeParameterSet
     */
    protected $includeParameterSet;

    /**
     *
     * @var ProtocolSet
     */
    protected $protocolSet;

    /**
     *
     * @return string $username
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
     * @return string $folder
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
     * @return string $transmissionType
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
     * @return string $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     *
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     *
     * @return string $ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * @param string $dnsAddress
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;
    }

    /**
     *
     * @return IncludeParameterSet $includeParameterSet
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
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

    /**
     *
     * @param ProtocolSet $protocolSet
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;
    }

}
