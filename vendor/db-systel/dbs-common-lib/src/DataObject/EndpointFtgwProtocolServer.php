<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * EndpointFtgwProtocolServer
 *
 * @ORM\Table(
 *     name="endpoint_ftgw_protocol_server",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_ftgw_protocol_server_include_parameter_set_idx", columns={"include_parameter_set_id"}),
 *         @ORM\Index(name="fk_endpoint_ftgw_protocol_server_protocol_set_idx", columns={"protocol_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class EndpointFtgwProtocolServer extends AbstractEndpoint
{

    /** @var string */
    const TRANSMISSION_TYPE_TXT = 'txt';
    /** @var string */
    const TRANSMISSION_TYPE_BIN = 'bin';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="folder", type="string", length=200, nullable=true)
     */
    protected $folder;

    /**
     * @var string
     *
     * @ORM\Column(name="transmission_type", type="string", nullable=true)
     */
    protected $transmissionType;

    /**
     * @var string
     *
     * @ORM\Column(name="port", type="string", length=5, nullable=true)
     */
    protected $port;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    protected $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="dns_address", type="string", length=253, nullable=true)
     */
    protected $dnsAddress;

    /**
     * @var IncludeParameterSet
     *
     * @ORM\OneToOne(targetEntity="IncludeParameterSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="include_parameter_set_id", referencedColumnName="id")
     * })
     */
    protected $includeParameterSet;

    /**
     * @var ProtocolSet
     *
     * @ORM\OneToOne(targetEntity="ProtocolSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="protocol_set_id", referencedColumnName="id")
     * })
     */
    protected $protocolSet;

    /**
     * @param string $username
     *
     * @return EndpointFtgwProtocolServer
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
     *
     * @return EndpointFtgwProtocolServer
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
     *
     * @return EndpointFtgwProtocolServer
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
     * @param string $port
     *
     * @return EndpointFtgwProtocolServer
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $ip
     *
     * @return EndpointFtgwProtocolServer
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $dnsAddress
     *
     * @return EndpointFtgwProtocolServer
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
     * @param IncludeParameterSet $includeParameterSet
     *
     * @return EndpointFtgwProtocolServer
     */
    public function setIncludeParameterSet(IncludeParameterSet $includeParameterSet)
    {
        $this->includeParameterSet = $includeParameterSet;

        return $this;
    }

    /**
     * @return IncludeParameterSet
     */
    public function getIncludeParameterSet()
    {
        return $this->includeParameterSet;
    }

    /**
     * @param ProtocolSet $protocolSet
     *
     * @return EndpointFtgwProtocolServer
     */
    public function setProtocolSet(ProtocolSet $protocolSet)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     * @return ProtocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }

}
