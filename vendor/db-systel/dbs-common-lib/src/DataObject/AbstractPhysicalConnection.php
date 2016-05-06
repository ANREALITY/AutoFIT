<?php
namespace DbSystel\DataObject;

abstract class AbstractPhysicalConnection extends AbstractDataObject
{

    const ROLE_END_TO_END = 'end_to_end';

    const ROLE_END_TO_MIDDLE = 'end_to_middle';

    const ROLE_MIDDLE_TO_END = 'middle_to_end';

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $role;

    /**
     *
     * @var string
     */
    protected $type;

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
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     *
     * @param string $role            
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     *
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type            
     */
    public function setType($type)
    {
        $this->type = $type;
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
