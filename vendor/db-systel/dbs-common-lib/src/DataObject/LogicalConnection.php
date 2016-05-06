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
    protected $physicalConnectionEndToEnd;

    /**
     *
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    protected $physicalConnectionEndToMiddle;

    /**
     *
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    protected $physicalConnectionMiddleToEnd;

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
     * @return the $physicalConnectionEndToEnd
     */
    public function getPhysicalConnectionEndToEnd()
    {
        return $this->physicalConnectionEndToEnd;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnectionEndToEnd
     */
    public function setPhysicalConnectionEndToEnd($physicalConnectionEndToEnd)
    {
        $this->physicalConnectionEndToEnd = $physicalConnectionEndToEnd;
    }

    /**
     *
     * @return the $physicalConnectionEndToMiddle
     */
    public function getPhysicalConnectionEndToMiddle()
    {
        return $this->physicalConnectionEndToMiddle;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnectionEndToMiddle
     */
    public function setPhysicalConnectionEndToMiddle($physicalConnectionEndToMiddle)
    {
        $this->physicalConnectionEndToMiddle = $physicalConnectionEndToMiddle;
    }

    /**
     *
     * @return the $physicalConnectionMiddleToEnd
     */
    public function getPhysicalConnectionMiddleToEnd()
    {
        return $this->physicalConnectionMiddleToEnd;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     */
    public function setPhysicalConnectionMiddleToEnd($physicalConnectionMiddleToEnd)
    {
        $this->physicalConnectionMiddleToEnd = $physicalConnectionMiddleToEnd;
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
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

}
