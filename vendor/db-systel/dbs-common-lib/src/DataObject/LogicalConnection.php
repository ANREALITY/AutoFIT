<?php
namespace DbSystel\DataObject;

class LogicalConnection extends AbstractDataObject
{

    const TYPE_CD = 'CD';

    const TYPE_FTGW = 'FTGW';

    /**
     *
     * @var integer
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
     * @return integer $id
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
     * @return AbstractPhysicalConnection $physicalConnectionEndToEnd
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
     * @return AbstractPhysicalConnection $physicalConnectionEndToMiddle
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
     * @return AbstractPhysicalConnection $physicalConnectionMiddleToEnd
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
     * @return Notification[] $notifications
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
