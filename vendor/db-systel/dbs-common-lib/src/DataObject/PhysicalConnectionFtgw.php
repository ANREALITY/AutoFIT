<?php
namespace DbSystel\DataObject;

class PhysicalConnectionFtgw
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
     * @param \DbSystel\DataObject\PhysicalConnection $physicalConnection
     */
    public function setPhysicalConnection($physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;
    }
}
