<?php
namespace Base\DataObject;

use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * FileTransferRequest
 *
 * @ORM\Table(
 *     name="file_transfer_request",
 *     indexes={
 *         @ORM\Index(name="fk_file_transfer_request_logical_connection_idx", columns={"logical_connection_id"}),
 *         @ORM\Index(name="fk_file_transfer_request_service_invoice_position_basic_idx", columns={"service_invoice_position_basic_number"}),
 *         @ORM\Index(name="fk_file_transfer_request_service_invoice_position_personal_idx", columns={"service_invoice_position_personal_number"}),
 *         @ORM\Index(name="fk_file_transfer_request_user_idx", columns={"user_id"})
 *     }
 * )
 * @ORM\Entity
 */
class FileTransferRequest extends AbstractDataObject
{

    /** @var string */
    const STATUS_EDIT = 'edit';
    /** @var string */
    const STATUS_PENDING = 'pending';
    /** @var string */
    const STATUS_CANCELED = 'canceled';
    /** @var string */
    const STATUS_CHECK = 'check';
    /** @var string */
    const STATUS_ACCEPTED = 'accepted';
    /** @var string */
    const STATUS_DECLINED = 'declined';
    /** @var string */
    const STATUS_COMPLETED = 'completed';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"export"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="change_number", type="string", length=50, nullable=false)
     *
     * @Groups({"export"})
     */
    protected $changeNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     *
     * @Groups({"export"})
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     *
     * @Groups({"export"})
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $updated;

    /**
     * @var LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $logicalConnection;

    /**
     * @var AbstractServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePositionBasic")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_basic_number", referencedColumnName="number")
     * })
     *
     * @Groups({"export"})
     */
    protected $serviceInvoicePositionBasic;

    /**
     * @var AbstractServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePositionPersonal")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_personal_number", referencedColumnName="number")
     * })
     *
     * @Groups({"export"})
     */
    protected $serviceInvoicePositionPersonal;

    /**
     * @ORM\ManyToMany(targetEntity="AbstractServiceInvoicePosition", inversedBy="fileTransferRequests")
     * @ORM\JoinTable(
     *     name="file_transfer_request_service_invoice_position",
     *     joinColumns={
     *         @ORM\JoinColumn(name="file_Transfer_request_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="service_invoice_position_number", referencedColumnName="number")
     *     }
     * )
     */
    protected $serviceInvoicePositions;

    public function __construct() {
        $this->serviceInvoicePositions = new ArrayCollection();
    }

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @Groups({"export"})
     */
    protected $user;

    /**
     * @param integer $id
     *
     * @return FileTransferRequest
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
     * @param string $changeNumber
     *
     * @return FileTransferRequest
     */
    public function setChangeNumber($changeNumber)
    {
        $this->changeNumber = $changeNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getChangeNumber()
    {
        return $this->changeNumber;
    }

    /**
     * @param string $status
     *
     * @return FileTransferRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $comment
     *
     * @return FileTransferRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param \DateTime $created
     *
     * @return FileTransferRequest
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
     * @return FileTransferRequest
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
     * @param LogicalConnection $logicalConnection
     *
     * @return FileTransferRequest
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection = null)
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
     * @param AbstractServiceInvoicePosition $serviceInvoicePositionBasic
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionBasic(AbstractServiceInvoicePosition $serviceInvoicePositionBasic = null)
    {
        if ($serviceInvoicePositionBasic) {
            $this->removeServiceInvoicePositionByType(AbstractServiceInvoicePosition::TYPE_BASIC);
            $this->addServiceInvoicePosition($serviceInvoicePositionBasic);
        }
        return $this;
    }

    /**
     * @return AbstractServiceInvoicePosition
     */
    public function getServiceInvoicePositionBasic()
    {
        $serviceInvoicePositionBasic = $this->getFirstInstanceOf(
            $this->getServiceInvoicePositions(), ServiceInvoicePositionBasic::class
        );
        return $serviceInvoicePositionBasic;
    }

    /**
     * @param AbstractServiceInvoicePosition $serviceInvoicePositionPersonal
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionPersonal(AbstractServiceInvoicePosition $serviceInvoicePositionPersonal = null)
    {
        if ($serviceInvoicePositionPersonal) {
            $this->removeServiceInvoicePositionByType(AbstractServiceInvoicePosition::TYPE_PERSONAL);
            $this->addServiceInvoicePosition($serviceInvoicePositionPersonal);
        }
        return $this;
    }

    /**
     * @return AbstractServiceInvoicePosition
     */
    public function getServiceInvoicePositionPersonal()
    {
        $serviceInvoicePositionPersonal = $this->getFirstInstanceOf(
            $this->getServiceInvoicePositions(), ServiceInvoicePositionPersonal::class
        );
        return $serviceInvoicePositionPersonal;
    }

    /**
     * @param User $user
     *
     * @return FileTransferRequest
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param AbstractServiceInvoicePosition[] $serviceInvoicePositions
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositions($serviceInvoicePositions)
    {
        $this->serviceInvoicePositions = new ArrayCollection([]);
        /** @var AbstractEndpoint $endpoint */
        foreach ($serviceInvoicePositions as $serviceInvoicePosition) {
            $this->addServiceInvoicePosition($serviceInvoicePosition);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $serviceInvoicePositions
     */
    public function getServiceInvoicePositions()
    {
        return $this->serviceInvoicePositions;
    }

    /**
     * @param AbstractServiceInvoicePosition $serviceInvoicePosition
     * @return FileTransferRequest
     */
    public function addServiceInvoicePosition(AbstractServiceInvoicePosition $serviceInvoicePosition)
    {
        $serviceInvoicePosition->addFileTransferRequest($this);
        $this->serviceInvoicePositions->add($serviceInvoicePosition);
        return $this;
    }

    /**
     * @param AbstractServiceInvoicePosition $serviceInvoicePosition
     * @return FileTransferRequest
     */
    public function removeServiceInvoicePosition(AbstractServiceInvoicePosition $serviceInvoicePosition)
    {
        $serviceInvoicePosition->removeFileTransferRequest($this);
        $this->serviceInvoicePositions->removeElement($serviceInvoicePosition);
        return $this;
    }

    public function exchangeArray()
    {
        return get_object_vars($this);
    }

    /**
     * Iterates over the given array and
     * returns the first instance of the given type found.
     *
     * @param AbstractServiceInvoicePosition[]|ArrayAccess $list
     * @param string $className
     * @return null
     */
    protected function getFirstInstanceOf($list, $className)
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
     * @param string $typeToRemove
     */
    protected function removeServiceInvoicePositionByType(string $typeToRemove)
    {
        /** @var AbstractServiceInvoicePosition $serviceInvoicePosition */
        foreach ($this->serviceInvoicePositions as $serviceInvoicePosition) {
            if (
                $serviceInvoicePosition->getType() === $typeToRemove
            ) {
                $this->removeServiceInvoicePosition($serviceInvoicePosition);
            }
        }
    }

}
