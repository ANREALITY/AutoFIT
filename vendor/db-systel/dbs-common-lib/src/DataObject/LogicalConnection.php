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
     * @param AbstractPhysicalConnection $physicalConnectionEndToEnd
     */
    public function setPhysicalConnectionEndToEnd($physicalConnectionEndToEnd)
    {
        $this->physicalConnectionEndToEnd = $physicalConnectionEndToEnd;

        return $this;
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
     * @param AbstractPhysicalConnection $physicalConnectionEndToMiddle
     */
    public function setPhysicalConnectionEndToMiddle($physicalConnectionEndToMiddle)
    {
        $this->physicalConnectionEndToMiddle = $physicalConnectionEndToMiddle;

        return $this;
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
     * @param AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     */
    public function setPhysicalConnectionMiddleToEnd($physicalConnectionMiddleToEnd)
    {
        $this->physicalConnectionMiddleToEnd = $physicalConnectionMiddleToEnd;

        return $this;
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
     * @param multitype:Notification $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     *
     * @return Notification[] $notifications
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

}
