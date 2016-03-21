<?php
namespace DbSystel\DataObject;

abstract class AbstractPhysicalConnection
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
     * @var AbstractEndpoint[] @relationshipInversion
     */
    protected $endpoints;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $endpointSource;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $endpointTarget;

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
     * @return the $endpoints
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     *
     * @param multitype:\DbSystel\DataObject\AbstractEndpoint $endpoints            
     */
    public function setEndpoints($endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     *
     * @return the $endpointSource
     */
    public function getEndpointSource()
    {
        return $this->endpointSource;
    }

    /**
     *
     * @param \DbSystel\DataObject\AbstractEndpoint $endpointSource            
     */
    public function setEndpointSource($endpointSource)
    {
        $this->endpointSource = $endpointSource;
    }

    /**
     *
     * @return the $endpointTarget
     */
    public function getEndpointTarget()
    {
        return $this->endpointTarget;
    }

    /**
     *
     * @param \DbSystel\DataObject\AbstractEndpoint $endpointTarget            
     */
    public function setEndpointTarget($endpointTarget)
    {
        $this->endpointTarget = $endpointTarget;
    }
}
