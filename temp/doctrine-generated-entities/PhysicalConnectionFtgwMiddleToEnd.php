<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnectionFtgwMiddleToEnd
 *
 * @ORM\Table(name="physical_connection_ftgw_middle_to_end")
 * @ORM\Entity
 */
class PhysicalConnectionFtgwMiddleToEnd extends AbstractPhysicalConnection
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
     * @return PhysicalConnectionFtgwMiddleToEnd
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
