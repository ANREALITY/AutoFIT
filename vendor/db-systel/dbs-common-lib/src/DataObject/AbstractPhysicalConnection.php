<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractPhysicalConnection
 */
abstract class AbstractPhysicalConnection extends AbstractDataObject
{

    const ROLE_END_TO_END = 'end_to_end';

    const ROLE_END_TO_MIDDLE = 'end_to_middle';

    const ROLE_MIDDLE_TO_END = 'middle_to_end';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $type;

    /**
     * @var boolean
     */
    private $securePlus;

    /**
     * @var string
     */
    private $created;

    /**
     * @var string
     */
    private $updated;

    /**
     * @var LogicalConnection
     */
    private $logicalConnection;

    /**
     * @var AbstractEndpoint @relationshipInversion
     */
    private $endpointSource;

    /**
     * @var AbstractEndpoint @relationshipInversion
     */
    private $endpointTarget;

    /**
     * @param integer $id
     *
     * @return AbstractPhysicalConnection
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $role
     *
     * @return AbstractPhysicalConnection
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $type
     *
     * @return AbstractPhysicalConnection
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $securePlus
     *
     * @return AbstractPhysicalConnection
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     * @param string $created
     *
     * @return AbstractPhysicalConnection
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $updated
     *
     * @return AbstractPhysicalConnection
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param LogicalConnection $logicalConnection
     *
     * @return AbstractPhysicalConnection
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * @return LogicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     * @param AbstractEndpoint $endpointSource
     *
     * @return AbstractPhysicalConnection
     */
    public function setEndpointSource($endpointSource)
    {
        $this->endpointSource = $endpointSource;

        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpointSource()
    {
        return $this->endpointSource;
    }

    /**
     * @param AbstractEndpoint $endpointTarget
     *
     * @return AbstractPhysicalConnection
     */
    public function setEndpointTarget($endpointTarget)
    {
        $this->endpointTarget = $endpointTarget;

        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpointTarget()
    {
        return $this->endpointTarget;
    }

}
