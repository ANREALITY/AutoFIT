<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * LogicalConnection
 *
 * @ORM\Table(name="logical_connection")
 * @ORM\Entity
 */
class LogicalConnection extends AbstractDataObject
{

    /** @var string */
    const TYPE_CD = 'CD';
    /** @var string */
    const TYPE_FTGW = 'FTGW';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     *
     * @Groups({"export"})
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * for export only
     *
     * @var AbstractPhysicalConnection #relationshipInversion
     *
     * @Groups({"export_cd"})
     */
    protected $physicalConnectionEndToEnd;

    /**
     * for export only
     *
     * @var AbstractPhysicalConnection #relationshipInversion
     *
     * @Groups({"export_ftgw"})
     */
    protected $physicalConnectionEndToMiddle;

    /**
     * for export only
     *
     * @var AbstractPhysicalConnection #relationshipInversion
     *
     * @Groups({"export_ftgw"})
     */
    protected $physicalConnectionMiddleToEnd;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AbstractPhysicalConnection", mappedBy="logicalConnection", cascade={"persist"})
     */
    protected $physicalConnections;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="logicalConnection", cascade={"persist"}, orphanRemoval=true)
     *
     * @Groups({"export"})
     */
    protected $notifications;

    public function __construct()
    {
        $this->physicalConnections = new ArrayCollection();
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
     * @param \DateTime $created
     *
     * @return LogicalConnection
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $updated
     *
     * @return LogicalConnection
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
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
        foreach ($this->physicalConnections as $physicalConnection) {
            if ($physicalConnection instanceof PhysicalConnectionCdEndToEnd) {
                $this->removePhysicalConnection($physicalConnection);
            }
        }
        $this->addPhysicalConnection($physicalConnectionEndToEnd);
        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionEndToEnd()
    {
        $physicalConnectionEndToEnd = $this->getFirstInstanceOf(
            $this->getPhysicalConnections(), PhysicalConnectionCdEndToEnd::class
        );
        return $physicalConnectionEndToEnd;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionEndToMiddle
     *
     * @return LogicalConnection
     */
    public function setPhysicalConnectionEndToMiddle($physicalConnectionEndToMiddle)
    {
        foreach ($this->physicalConnections as $physicalConnection) {
            if ($physicalConnection instanceof PhysicalConnectionFtgwEndToMiddle) {
                $this->removePhysicalConnection($physicalConnection);
            }
        }
        $this->addPhysicalConnection($physicalConnectionEndToMiddle);
        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionEndToMiddle()
    {
        $physicalConnectionEndToMiddle = $this->getFirstInstanceOf(
            $this->getPhysicalConnections(), PhysicalConnectionFtgwEndToMiddle::class
        );
        return $physicalConnectionEndToMiddle;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnectionMiddleToEnd
     *
     * @return LogicalConnection
     */
    public function setPhysicalConnectionMiddleToEnd($physicalConnectionMiddleToEnd)
    {
        foreach ($this->physicalConnections as $physicalConnection) {
            if ($physicalConnection instanceof PhysicalConnectionFtgwMiddleToEnd) {
                $this->removePhysicalConnection($physicalConnection);
            }
        }
        $this->addPhysicalConnection($physicalConnectionMiddleToEnd);
        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionMiddleToEnd()
    {
        $physicalConnectionMiddleToEnd = $this->getFirstInstanceOf(
            $this->getPhysicalConnections(), PhysicalConnectionFtgwMiddleToEnd::class
        );
        return $physicalConnectionMiddleToEnd;
    }

    /**
     * @param AbstractPhysicalConnection[] $physicalConnections
     * @return LogicalConnection
     */
    public function setPhysicalConnections($physicalConnections)
    {
        $this->physicalConnections = new ArrayCollection([]);
        /** @var AbstractPhysicalConnection $physicalConnection */
        foreach ($physicalConnections as $physicalConnection) {
            $this->addPhysicalConnection($physicalConnection);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhysicalConnections()
    {
        return $this->physicalConnections;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnection
     * @return LogicalConnection
     */
    public function addPhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        $this->physicalConnections->add($physicalConnection);
        $physicalConnection->setLogicalConnection($this);
        return $this;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnection
     * @return LogicalConnection
     */
    public function removePhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        $this->physicalConnections->removeElement($physicalConnection);
        return $this;
    }

    /**
     * @param ArrayCollection $notifications
     *
     * @return LogicalConnection
     */
    public function setNotifications($notifications)
    {
        $this->removeNotificationsNotInList($notifications);
        $this->notifications = new ArrayCollection([]);
        /** @var Notification $notification */
        foreach ($notifications as $notification) {
            $this->addNotification($notification);
        }
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
        $notification->setLogicalConnection($this);
        return $this;
    }

    /**
     * @param Notification $notification
     * @return LogicalConnection
     */
    public function removeNotification(Notification $notification)
    {
        $this->notifications->removeElement($notification);
        $notification->setLogicalConnection(null);
        return $this;
    }

    /**
     * Iterates over the given array and
     * returns the first instance of the given type found.
     *
     * @param $list
     * @param string $className
     * @return AbstractDataObject|null
     */
    protected function getFirstInstanceOf($list, string $className)
    {
        $return = null;
        foreach ($list as $element) {
            if ($element instanceof $className) {
                $return = $element;
                break;
            }
        }
        return $return;
    }

    /**
     * @param $notifications
     * @return void
     */
    private function removeNotificationsNotInList($notifications)
    {
        if (is_array($notifications)) {
            $notifications = new ArrayCollection($notifications);
        }
        foreach ($this->getNotifications() as $notification) {
            if ($notifications->indexOf($notification) === false) {
                $this->removeNotification($notification);
            }
        }
    }

}
