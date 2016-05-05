<?php
namespace DbSystel\DataObject;

class LogicalConnection extends AbstractDataObject
{

    const TYPE_CD = 'CD';

    const TYPE_FTGW = 'FTGW';

    /**
     *
     * @var int
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    protected $physicalConnectionSource;

    /**
     *
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    protected $physicalConnectionTarget;

    /**
     *
     * @var Notification[]
     */
    protected $notifications;

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
     * @return the $physicalConnectionSource
     */
    public function getPhysicalConnectionSource()
    {
        return $this->physicalConnectionSource;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnectionSource            
     */
    public function setPhysicalConnectionSource($physicalConnectionSource)
    {
        $this->physicalConnectionSource = $physicalConnectionSource;
    }

    /**
     *
     * @return the $physicalConnectionTarget
     */
    public function getPhysicalConnectionTarget()
    {
        return $this->physicalConnectionTarget;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnectionTarget            
     */
    public function setPhysicalConnectionTarget($physicalConnectionTarget)
    {
        $this->physicalConnectionTarget = $physicalConnectionTarget;
    }

    /**
     *
     * @return the $notifications
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     *
     * @param multitype:Notification $notifications            
     */
    public function setNotifications(array $notifications)
    {
        $this->notifications = $notifications;
    }

}
