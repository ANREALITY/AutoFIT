<?php
namespace DbSystel\DataObject;

class PhysicalConnectionFtgw extends AbstractPhysicalConnection
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
    public function setPhysicalConnection($physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;
    }
}
