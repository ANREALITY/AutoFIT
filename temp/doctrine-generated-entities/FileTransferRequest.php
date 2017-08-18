<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileTransferRequest
 *
 * @ORM\Table(name="file_transfer_request", indexes={@ORM\Index(name="fk_file_transfer_request_logical_connection_idx", columns={"logical_connection_id"}), @ORM\Index(name="fk_file_transfer_request_service_invoice_position_basic_idx", columns={"service_invoice_position_basic_number"}), @ORM\Index(name="fk_file_transfer_request_service_invoice_position_personal_idx", columns={"service_invoice_position_personal_number"}), @ORM\Index(name="fk_file_transfer_request_user_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class FileTransferRequest extends AbstractDataObject
{
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
     * @ORM\Column(name="change_number", type="string", length=50, nullable=false)
     */
    private $changeNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status = 'edit';

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=500, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    private $logicalConnection;

    /**
     * @var ServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_basic_number", referencedColumnName="number")
     * })
     */
    private $serviceInvoicePositionBasicNumber;

    /**
     * @var ServiceInvoicePosition
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoicePosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_position_personal_number", referencedColumnName="number")
     * })
     */
    private $serviceInvoicePositionPersonalNumber;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;



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
     * @param ServiceInvoicePosition $serviceInvoicePositionBasicNumber
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionBasicNumber(ServiceInvoicePosition $serviceInvoicePositionBasicNumber = null)
    {
        $this->serviceInvoicePositionBasicNumber = $serviceInvoicePositionBasicNumber;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition
     */
    public function getServiceInvoicePositionBasicNumber()
    {
        return $this->serviceInvoicePositionBasicNumber;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePositionPersonalNumber
     *
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionPersonalNumber(ServiceInvoicePosition $serviceInvoicePositionPersonalNumber = null)
    {
        $this->serviceInvoicePositionPersonalNumber = $serviceInvoicePositionPersonalNumber;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition
     */
    public function getServiceInvoicePositionPersonalNumber()
    {
        return $this->serviceInvoicePositionPersonalNumber;
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
}
