<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointServerConfig
 *
 * @ORM\Table(name="endpoint_server_config", indexes={
 *     @ORM\Index(name="fk_endpoint_server_config_server_idx", columns={"server_name"})}
 * )
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
     * @var Server
     *
     * @ORM\ManyToOne(targetEntity="Server")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="server_name", referencedColumnName="name")
     * })
     */
    private $server;

    /**
     * @var AbstractEndpoint
     *
     * @ORM\OneToOne(targetEntity="AbstractEndpoint", mappedBy="endpointServerConfig")
     */
    private $endpoint;

    /**
     * @param integer $id
     *
     * @return EndpointServerConfig
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
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
     * @return string
     */
    public function getDnsAddress()
    {
        return $this->dnsAddress;
    }

    /**
     * @param Server $server
     *
     * @return EndpointServerConfig
     */
    public function setServer(Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param AbstractEndpoint $endpoint
     *
     * @return EndpointServerConfig
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

}
