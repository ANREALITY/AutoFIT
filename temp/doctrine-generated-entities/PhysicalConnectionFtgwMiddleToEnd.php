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
     * @var AbstractPhysicalConnection
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AbstractPhysicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="physical_connection_id", referencedColumnName="id")
     * })
     */
    private $physicalConnection;



    /**
     * @param AbstractPhysicalConnection $physicalConnection
     *
     * @return PhysicalConnectionFtgwMiddleToEnd
     */
    public function setPhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

}
