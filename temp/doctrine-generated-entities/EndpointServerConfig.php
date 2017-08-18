<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointServerConfig
 *
 * @ORM\Table(name="endpoint_server_config", indexes={@ORM\Index(name="fk_endpoint_server_config_server_idx", columns={"server_name"})})
 * @ORM\Entity
 */
class EndpointServerConfig extends AbstractDataObject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dns_address", type="string", length=253, nullable=true)
     */
    private $dnsAddress;

    /**
     * @var \Server
     *
     * @ORM\ManyToOne(targetEntity="Server")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_name", referencedColumnName="name")
     * })
     */
    private $serverName;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dnsAddress
     *
     * @param string $dnsAddress
     *
     * @return EndpointServerConfig
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;

        return $this;
    }

    /**
     * Get dnsAddress
     *
     * @return string
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     * Set serverName
     *
     * @param \Server $serverName
     *
     * @return EndpointServerConfig
     */
    public function setServerName(\Server $serverName = null)
    {
        $this->serverName = $serverName;

        return $this;
    }

    /**
     * Get serverName
     *
     * @return \Server
     */
    public function getServerName()
    {
        return $this->serverName;
    }
}
