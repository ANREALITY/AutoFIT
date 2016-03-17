<?php
namespace DbSystel\DataObject;

abstract class AbstractSpecificPhysicalConnection
{

    /**
     *
     * @var BasicPhysicalConnection
     */
    protected $basicPhysicalConnection;

    /**
     *
     * @return the $basicPhysicalConnection
     */
    public function getBasicPhysicalConnection()
    {
        return $this->basicPhysicalConnection;
    }

    /**
     *
     * @param \DbSystel\DataObject\BasicPhysicalConnection $basicPhysicalConnection            
     */
    public function setBasicPhysicalConnection($basicPhysicalConnection)
    {
        $this->basicPhysicalConnection = $basicPhysicalConnection;
    }
}
