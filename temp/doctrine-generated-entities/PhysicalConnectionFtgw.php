<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhysicalConnectionFtgw
 *
 * @ORM\Table(name="physical_connection_ftgw")
 * @ORM\Entity
 */
class PhysicalConnectionFtgw extends AbstractDataObject
{
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
     * Set physicalConnection
     *
     * @param \PhysicalConnection $physicalConnection
     *
     * @return PhysicalConnectionFtgw
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
