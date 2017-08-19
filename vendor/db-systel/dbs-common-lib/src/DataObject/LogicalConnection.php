<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * LogicalConnection
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
     * @var string
     */
    private $created;

    /**
     * @var string
     */
    private $updated;

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
     * @var ArrayCollection
     */
    private $notifications;

    public function __construct()
    {
        $this->notifications = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return LogicalConnection
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
     * @param string $type
     *
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
     * @param string $created
     *
     * @return LogicalConnection
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
     * @return LogicalConnection
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
     * @param AbstractPhysicalConnection $physicalConnectionEndToEnd
     *
     * @return LogicalConnection
     */
    public function setPhysicalConnectionEndToEnd($physicalConnectionEndToEnd)
    {
        $this->physicalConnectionEndToEnd = $physicalConnectionEndToEnd;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionEndToEnd()
    {
        return $this->physicalConnectionEndToEnd;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionEndToMiddle
     *
     * @return LogicalConnection
     */
    public function setPhysicalConnectionEndToMiddle($physicalConnectionEndToMiddle)
    {
        $this->physicalConnectionEndToMiddle = $physicalConnectionEndToMiddle;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionEndToMiddle()
    {
        return $this->physicalConnectionEndToMiddle;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     *
     * @return LogicalConnection
     */
    public function setPhysicalConnectionMiddleToEnd($physicalConnectionMiddleToEnd)
    {
        $this->physicalConnectionMiddleToEnd = $physicalConnectionMiddleToEnd;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionMiddleToEnd()
    {
        return $this->physicalConnectionMiddleToEnd;
    }

    /**
     * @param ArrayCollection $notifications
     *
     * @return LogicalConnection
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * @return ArrayCollection $notifications
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param Notification $notification
     * @return LogicalConnection
     */
    public function addNotification(Notification $notification)
    {
        $this->notifications->add($notification);
        return $this;
    }

    /**
     * @param Notification $notification
     * @return LogicalConnection
     */
    public function removeNotification(Notification $notification)
    {
        $this->notifications->removeElement($notification);
        return $this;
    }

}
