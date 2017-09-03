<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use DbSystel\Annotation\Export;

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
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="change_number", type="string", length=50, nullable=false)
     */
    protected $changeNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     */
    protected $comment;

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
     * @var LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    protected $logicalConnection;

    /**
     * @var ServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_basic_number", referencedColumnName="number")
     * })
     */
    protected $serviceInvoicePositionBasic;

    /**
     * @var ServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_personal_number", referencedColumnName="number")
     * })
     */
    protected $serviceInvoicePositionPersonal;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
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
        // @todo Change later back to DateTime!
        return is_string($this->created) || empty($this->created)
            ? $this->created : $this->created->format('Y-m-d H:i:s')
        ;
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
     * @param ServiceInvoicePosition $serviceInvoicePositionBasic
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionBasic(ServiceInvoicePosition $serviceInvoicePositionBasic = null)
    {
        $this->serviceInvoicePositionBasic = $serviceInvoicePositionBasic;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition
     */
    public function getServiceInvoicePositionBasic()
    {
        return $this->serviceInvoicePositionBasic;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePositionPersonal
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionPersonal(ServiceInvoicePosition $serviceInvoicePositionPersonal = null)
    {
        $this->serviceInvoicePositionPersonal = $serviceInvoicePositionPersonal;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition
     */
    public function getServiceInvoicePositionPersonal()
    {
        return $this->serviceInvoicePositionPersonal;
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

    public function exchangeArray()
    {
        return get_object_vars($this);
    }

}
