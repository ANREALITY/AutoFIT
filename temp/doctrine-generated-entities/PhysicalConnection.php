<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnection
 *
 * @ORM\Table(name="physical_connection", indexes={@ORM\Index(name="fk_physical_connection_logical_connection_idx", columns={"logical_connection_id"})})
 * @ORM\Entity
 */
class PhysicalConnection
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
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="secure_plus", type="boolean", nullable=true)
     */
    private $securePlus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var \LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    private $logicalConnection;



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
     * Set role
     *
     * @param string $role
     *
     * @return PhysicalConnection
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return PhysicalConnection
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set securePlus
     *
     * @param boolean $securePlus
     *
     * @return PhysicalConnection
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;

        return $this;
    }

    /**
     * Get securePlus
     *
     * @return boolean
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return PhysicalConnection
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return PhysicalConnection
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set logicalConnection
     *
     * @param \LogicalConnection $logicalConnection
     *
     * @return PhysicalConnection
     */
    public function setLogicalConnection(\LogicalConnection $logicalConnection = null)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * Get logicalConnection
     *
     * @return \LogicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }
}
