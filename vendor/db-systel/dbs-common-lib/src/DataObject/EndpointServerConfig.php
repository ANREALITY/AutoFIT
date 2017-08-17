<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointServerConfig
 */
class EndpointServerConfig extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $dnsAddress;

    /**
     * @var Server
     */
    private $server;

    /**
     * @var AbstractEndpoint
     */
    private $endpoint;

    /**
     * @param integer $id
     * @return EndpointServerConfig
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $dnsAddress
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
     * @return EndpointServerConfig
     */
    public function setServer(Server $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return Server $server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return EndpointServerConfig
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

}