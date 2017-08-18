<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnectionCd
 *
 * @ORM\Table(name="physical_connection_cd")
 * @ORM\Entity
 */
class PhysicalConnectionCd
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="secure_plus", type="boolean", nullable=true)
     */
    private $securePlus;

    /**
     * @var \PhysicalConnection
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="PhysicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="physical_connection_id", referencedColumnName="id")
     * })
     */
    private $physicalConnection;



    /**
     * Set securePlus
     *
     * @param boolean $securePlus
     *
     * @return PhysicalConnectionCd
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
     * Set physicalConnection
     *
     * @param \PhysicalConnection $physicalConnection
     *
     * @return PhysicalConnectionCd
     */
    public function setPhysicalConnection(\PhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     * Get physicalConnection
     *
     * @return \PhysicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }
}
