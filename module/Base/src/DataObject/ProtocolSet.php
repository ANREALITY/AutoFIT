<?php
namespace Base\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ORM\OneToMany(targetEntity="Protocol", mappedBy="protocolSet", cascade={"persist"}, orphanRemoval=true)
     *
     * @Groups({"export"})
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
        $this->removeProtocolsNotInList($protocols);
        $this->protocols = new ArrayCollection([]);
        /** @var Protocol $protocol */
        foreach ($protocols as $protocol) {
            $this->addProtocol($protocol);
        }
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
        $protocol->setProtocolSet($this);
        return $this;
    }

    /**
     * @param Protocol $protocol
     * @return ProtocolSet
     */
    public function removeProtocol(Protocol $protocol)
    {
        $this->protocols->removeElement($protocol);
        $protocol->setProtocolSet(null);
        return $this;
    }

    /**
     * @param $protocols
     * @return void
     */
    private function removeProtocolsNotInList($protocols)
    {
        if (is_array($protocols)) {
            $protocols = new ArrayCollection($protocols);
        }
        foreach ($this->getProtocols() as $protocol) {
            if ($protocols->indexOf($protocol) === false) {
                $this->removeProtocol($protocol);
            }
        }
    }

}
