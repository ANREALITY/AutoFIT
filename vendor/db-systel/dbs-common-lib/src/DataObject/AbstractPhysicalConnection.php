<?php
namespace DbSystel\DataObject;

abstract class AbstractPhysicalConnection
{

    /**
     *
     * @var PhysicalConnection
     */
    protected $physicalConnection;

    /**
     *
     * @return the $physicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

    /**
     *
     * @param PhysicalConnection $physicalConnection            
     */
    public function setPhysicalConnection(PhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;
    }
}
