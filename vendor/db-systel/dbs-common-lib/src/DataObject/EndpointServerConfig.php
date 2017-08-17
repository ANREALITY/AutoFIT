<?php
namespace DbSystel\DataObject;

class EndpointServerConfig extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $dnsAddress;

    /**
     *
     * @var Server
     */
    protected $server;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $dnsAddress
     */
    public function setDnsAddress($dnsAddress)
    {
        $this->dnsAddress = $dnsAddress;

        return $this;
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
     * @param Server $server
     */
    public function setServer(Server $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     *
     * @return Server $server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     *
     * @param AbstractEndpoint $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     *
     * @return AbstractEndpoint $endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

}