<?php
namespace DbSystel\DataObject;

/**
 * Class LogicalConnection
 *
 * @package DbSystel\DataObject
 */
class LogicalConnection extends AbstractDataObject
{

    const TYPE_CD = 'CD';

    const TYPE_FTGW = 'FTGW';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    private $physicalConnectionEndToEnd;

    /**
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    private $physicalConnectionEndToMiddle;

    /**
     * @var AbstractPhysicalConnection @relationshipInversion
     */
    private $physicalConnectionMiddleToEnd;

    /**
     * @var Notification[]
     */
    private $notifications;

    /**
     * @param integer $id
     * @return LogicalConnection
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $type
     * @return LogicalConnection
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
     * @param AbstractPhysicalConnection $physicalConnectionEndToEnd
     * @return LogicalConnection
     */
    public function setPhysicalConnectionEndToEnd($physicalConnectionEndToEnd)
    {
        $this->physicalConnectionEndToEnd = $physicalConnectionEndToEnd;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection $physicalConnectionEndToEnd
     */
    public function getPhysicalConnectionEndToEnd()
    {
        return $this->physicalConnectionEndToEnd;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionEndToMiddle
     * @return LogicalConnection
     */
    public function setPhysicalConnectionEndToMiddle($physicalConnectionEndToMiddle)
    {
        $this->physicalConnectionEndToMiddle = $physicalConnectionEndToMiddle;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection $physicalConnectionEndToMiddle
     */
    public function getPhysicalConnectionEndToMiddle()
    {
        return $this->physicalConnectionEndToMiddle;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     * @return LogicalConnection
     */
    public function setPhysicalConnectionMiddleToEnd($physicalConnectionMiddleToEnd)
    {
        $this->physicalConnectionMiddleToEnd = $physicalConnectionMiddleToEnd;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     */
    public function getPhysicalConnectionMiddleToEnd()
    {
        return $this->physicalConnectionMiddleToEnd;
    }

    /**
     * @param Notification[] $notifications
     * @return LogicalConnection
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * @return Notification[] $notifications
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

}
