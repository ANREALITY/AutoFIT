<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnectionCdEndToEnd
 *
 * @ORM\Table(name="physical_connection_cd_end_to_end")
 * @ORM\Entity
 */
class PhysicalConnectionCdEndToEnd extends AbstractDataObject
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="secure_plus", type="boolean", nullable=true)
     */
    private $securePlus;

    /**
     * @var PhysicalConnection
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
     * @param boolean $securePlus
     *
     * @return PhysicalConnectionCdEndToEnd
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     * @param PhysicalConnection $physicalConnection
     *
     * @return PhysicalConnectionCdEndToEnd
     */
    public function setPhysicalConnection(PhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     * @return PhysicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

}
