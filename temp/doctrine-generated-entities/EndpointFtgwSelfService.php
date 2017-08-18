<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointFtgwSelfService
 *
 * @ORM\Table(name="endpoint_ftgw_self_service", indexes={@ORM\Index(name="fk_endpoint_ftgw_self_service_protocol_set_idx", columns={"protocol_set_id"})})
 * @ORM\Entity
 */
class EndpointFtgwSelfService extends AbstractDataObject
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
     * @var Endpoint
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
     * @var ProtocolSet
     *
     * @ORM\ManyToOne(targetEntity="ProtocolSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="protocol_set_id", referencedColumnName="id")
     * })
     */
    private $protocolSet;



    /**
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
     * @return string
     */
    public function getFtgwUsername()
    {
        return $this->ftgwUsername;
    }

    /**
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
     * @return string
     */
    public function getMailbox()
    {
        return $this->mailbox;
    }

    /**
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
     * @return string
     */
    public function getConnectionType()
    {
        return $this->connectionType;
    }

    /**
     * @param Endpoint $endpoint
     *
     * @return EndpointFtgwSelfService
     */
    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @return Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @param ProtocolSet $protocolSet
     *
     * @return EndpointFtgwSelfService
     */
    public function setProtocolSet(ProtocolSet $protocolSet = null)
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
