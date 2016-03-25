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
     * @var AbstractEndpoint @relationshipInversion
     */
    protected $endpointSource;

    /**
     *
     * @var AbstractEndpoint @relationshipInversion
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
     * @param LogicalConnection $logicalConnection            
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;
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
     * @param AbstractEndpoint $endpointSource
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
     * @param AbstractEndpoint $endpointTarget
     */
    public function setEndpointTarget($endpointTarget)
    {
        $this->endpointTarget = $endpointTarget;
    }
}
