<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnectionFtgwEndToMiddle
 *
 * @ORM\Table(name="physical_connection_ftgw_end_to_middle")
 * @ORM\Entity
 */
class PhysicalConnectionFtgwEndToMiddle extends AbstractPhysicalConnection
{

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
     * @param PhysicalConnection $physicalConnection
     *
     * @return PhysicalConnectionFtgwEndToMiddle
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
