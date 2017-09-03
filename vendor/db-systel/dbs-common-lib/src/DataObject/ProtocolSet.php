<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProtocolSet
 *
 * @ORM\Table(name="protocol_set")
 * @ORM\Entity
 */
class ProtocolSet extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var AbstractEndpoint
     */
    protected $endpoint;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Protocol", mappedBy="protocolSet")
     */
    protected $protocols;

    public function __construct()
    {
        $this->protocols = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return ProtocolSet
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
     * @param AbstractEndpoint $endpoint
     *
     * @return ProtocolSet
     */
    public function setEndpoint(AbstractEndpoint $endpoint)
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

    /**
     * @param ArrayCollection $protocols
     *
     * @return ProtocolSet
     */
    public function setProtocols($protocols)
    {
        $this->protocols = $protocols;
        return $this;
    }

    /**
     * @return ArrayCollection $protocols
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

    /**
     * @param Protocol $protocol
     * @return ProtocolSet
     */
    public function addProtocol(Protocol $protocol)
    {
        $this->protocols->add($protocol);
        return $this;
    }

    /**
     * @param Protocol $protocol
     * @return ProtocolSet
     */
    public function removeProtocol(Protocol $protocol)
    {
        $this->protocols->removeElement($protocol);
        return $this;
    }

}
