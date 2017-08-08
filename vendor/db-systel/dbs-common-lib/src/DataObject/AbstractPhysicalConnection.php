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
     * @var boolean
     */
    protected $securePlus;

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
     * @return int $id
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
     * @return string $role
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
     * @return string $type
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
     * @return boolean $securePlus
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
     * @return LogicalConnection $logicalConnection
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
     * @return AbstractEndpoint $endpointSource
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
     * @return AbstractEndpoint $endpointTarget
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
