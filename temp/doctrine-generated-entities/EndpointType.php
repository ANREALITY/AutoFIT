<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointType
 *
 * @ORM\Table(name="endpoint_type")
 * @ORM\Entity
 */
class EndpointType
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=true)
     */
    private $label;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ServerType", mappedBy="endpointType")
     */
    private $serverType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->serverType = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return EndpointType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return EndpointType
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add serverType
     *
     * @param \ServerType $serverType
     *
     * @return EndpointType
     */
    public function addServerType(\ServerType $serverType)
    {
        $this->serverType[] = $serverType;

        return $this;
    }

    /**
     * Remove serverType
     *
     * @param \ServerType $serverType
     */
    public function removeServerType(\ServerType $serverType)
    {
        $this->serverType->removeElement($serverType);
    }

    /**
     * Get serverType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServerType()
    {
        return $this->serverType;
    }
}
