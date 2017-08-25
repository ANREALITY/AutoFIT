<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var AbstractPhysicalConnection #relationshipInversion
     */
    private $physicalConnectionEndToEnd;

    /**
     * @var AbstractPhysicalConnection #relationshipInversion
     */
    private $physicalConnectionEndToMiddle;

    /**
     * @var AbstractPhysicalConnection #relationshipInversion
     */
    private $physicalConnectionMiddleToEnd;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AbstractPhysicalConnection", mappedBy="logicalConnection")
     */
    private $physicalConnections;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="logicalConnection")
     */
    private $notifications;

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
        $this->physicalConnectionEndToEnd = $physicalConnectionEndToEnd;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnectionEndToEnd()
    {
        if (! $this->physicalConnectionEndToEnd) {
            $this->physicalConnectionEndToEnd = $this->getFirstInstanceOf(
                $this->getPhysicalConnections(), PhysicalConnectionCdEndToEnd::class
            );
        }
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
        if (! $this->physicalConnectionEndToMiddle) {
            $this->physicalConnectionEndToMiddle = $this->getFirstInstanceOf(
                $this->getPhysicalConnections(), PhysicalConnectionFtgwEndToMiddle::class
            );
        }
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
        if (! $this->physicalConnectionMiddleToEnd) {
            $this->physicalConnectionMiddleToEnd = $this->getFirstInstanceOf(
                $this->getPhysicalConnections(), PhysicalConnectionFtgwMiddleToEnd::class
            );
        }
        return $this->physicalConnectionMiddleToEnd;
    }

    /**
     * @param AbstractPhysicalConnection[] $physicalConnections
     * @return LogicalConnection
     */
    public function setPhysicalConnections(array $physicalConnections)
    {
        $this->physicalConnections = $physicalConnections;
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

}
