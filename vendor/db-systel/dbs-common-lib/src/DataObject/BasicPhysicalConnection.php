<?php
namespace DbSystel\DataObject;

class BasicPhysicalConnection
{

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var LogicalConnection
     */
    protected $logicalConnection;

    /**
     *
     * @var AbstractSpecificEndpoint[] @relationshipInversion
     */
    protected $specificEndpoints;

    /**
     *
     * @var AbstractSpecificEndpoint
     */
    protected $specificEndpointSource;

    /**
     *
     * @var AbstractSpecificEndpoint
     */
    protected $specificEndpointTarget;

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     *
     * @param \DbSystel\DataObject\LogicalConnection $logicalConnection            
     */
    public function setLogicalConnection($logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;
    }

    /**
     *
     * @return the $specificEndpoints
     */
    public function getSpecificEndpoints()
    {
        return $this->specificEndpoints;
    }

    /**
     *
     * @param multitype:\DbSystel\DataObject\AbstractSpecificEndpoint $specificEndpoints            
     */
    public function setSpecificEndpoints($specificEndpoints)
    {
        $this->specificEndpoints = $specificEndpoints;
    }

    /**
     *
     * @return the $specificEndpointSource
     */
    public function getSpecificEndpointSource()
    {
        return $this->specificEndpointSource;
    }

    /**
     *
     * @param \DbSystel\DataObject\AbstractSpecificEndpoint $specificEndpointSource            
     */
    public function setSpecificEndpointSource($specificEndpointSource)
    {
        $this->specificEndpointSource = $specificEndpointSource;
    }

    /**
     *
     * @return the $specificEndpointTarget
     */
    public function getSpecificEndpointTarget()
    {
        return $this->specificEndpointTarget;
    }

    /**
     *
     * @param \DbSystel\DataObject\AbstractSpecificEndpoint $specificEndpointTarget            
     */
    public function setSpecificEndpointTarget($specificEndpointTarget)
    {
        $this->specificEndpointTarget = $specificEndpointTarget;
    }
}
