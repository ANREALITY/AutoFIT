<?php
namespace DbSystel\DataObject;

abstract class AbstractPhysicalConnection extends AbstractDataObject
{

    const ROLE_END_TO_END = 'end_to_end';

    const ROLE_END_TO_MIDDLE = 'end_to_middle';

    const ROLE_MIDDLE_TO_END = 'middle_to_end';

    /**
     *
     * @var integer
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
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
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
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * @param boolean $securePlus
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;

        return $this;
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
     * @param LogicalConnection $logicalConnection
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
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
     * @param AbstractEndpoint $endpointSource
     */
    public function setEndpointSource($endpointSource)
    {
        $this->endpointSource = $endpointSource;

        return $this;
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
     * @param AbstractEndpoint $endpointTarget
     */
    public function setEndpointTarget($endpointTarget)
    {
        $this->endpointTarget = $endpointTarget;

        return $this;
    }

    /**
     *
     * @return AbstractEndpoint $endpointTarget
     */
    public function getEndpointTarget()
    {
        return $this->endpointTarget;
    }

}
