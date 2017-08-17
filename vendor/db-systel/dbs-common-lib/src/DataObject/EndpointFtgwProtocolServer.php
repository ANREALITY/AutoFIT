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
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

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
     * @param string $folder
     */
    public function setFolder($folder)
    {
        $this->folder = $folder;
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
     * @param string $transmissionType
     */
    public function setTransmissionType($transmissionType)
    {
        $this->transmissionType = $transmissionType;
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
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
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
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * @param IncludeParameterSet $includeParameterSet
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;
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
     * @param ProtocolSet $protocolSet
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;
    }

    /**
     *
     * @return ProtocolSet $protocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}
