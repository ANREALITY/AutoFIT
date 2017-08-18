<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwSelfService
 *
 * @ORM\Table(name="endpoint_ftgw_self_service", indexes={@ORM\Index(name="fk_endpoint_ftgw_self_service_protocol_set_idx", columns={"protocol_set_id"})})
 * @ORM\Entity
 */
class EndpointFtgwSelfService
{
    /**
     * @var string
     *
     * @ORM\Column(name="ftgw_username", type="string", length=50, nullable=true)
     */
    private $ftgwUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="mailbox", type="string", length=50, nullable=true)
     */
    private $mailbox;

    /**
     * @var string
     *
     * @ORM\Column(name="connection_type", type="string", nullable=true)
     */
    private $connectionType;

    /**
     * @var \Endpoint
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Endpoint")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_id", referencedColumnName="id")
     * })
     */
    private $endpoint;

    /**
     * @var \ProtocolSet
     *
     * @ORM\ManyToOne(targetEntity="ProtocolSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="protocol_set_id", referencedColumnName="id")
     * })
     */
    private $protocolSet;



    /**
     * Set ftgwUsername
     *
     * @param string $ftgwUsername
     *
     * @return EndpointFtgwSelfService
     */
    public function setFtgwUsername($ftgwUsername)
    {
        $this->ftgwUsername = $ftgwUsername;

        return $this;
    }

    /**
     * Get ftgwUsername
     *
     * @return string
     */
    public function getFtgwUsername()
    {
        return $this->ftgwUsername;
    }

    /**
     * Set mailbox
     *
     * @param string $mailbox
     *
     * @return EndpointFtgwSelfService
     */
    public function setMailbox($mailbox)
    {
        $this->mailbox = $mailbox;

        return $this;
    }

    /**
     * Get mailbox
     *
     * @return string
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
     * Set connectionType
     *
     * @param string $connectionType
     *
     * @return EndpointFtgwSelfService
     */
    public function setConnectionType($connectionType)
    {
        $this->connectionType = $connectionType;

        return $this;
    }

    /**
     * Get connectionType
     *
     * @return string
     */
    public function getConnectionType()
    {
        return $this->connectionType;
    }

    /**
     * Set endpoint
     *
     * @param \Endpoint $endpoint
     *
     * @return EndpointFtgwSelfService
     */
    public function setEndpoint(\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Get endpoint
     *
     * @return \Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set protocolSet
     *
     * @param \ProtocolSet $protocolSet
     *
     * @return EndpointFtgwSelfService
     */
    public function setProtocolSet(\ProtocolSet $protocolSet = null)
    {
        $this->protocolSet = $protocolSet;

        return $this;
    }

    /**
     * Get protocolSet
     *
     * @return \ProtocolSet
     */
    public function getProtocolSet()
    {
        return $this->protocolSet;
    }
}
