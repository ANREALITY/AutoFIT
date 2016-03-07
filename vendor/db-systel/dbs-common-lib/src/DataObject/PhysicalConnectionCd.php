<?php
namespace DbSystel\DataObject;

class PhysicalConnectionCd
{

    /**
     *
     * @var boolean
     */
    protected $securePlus;

    /**
     *
     * @var PhysicalConnection
     */
    protected $physicalConnection;

    /**
     *
     * @return the $securePlus
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     *
     * @param boolean $securePlus            
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;
    }

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
