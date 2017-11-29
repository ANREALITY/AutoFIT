<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * OwnershipChangeRequest
 *
 * @ORM\Table(
 * name="ownership_change_requests",
 *     indexes={
 *         @ORM\Index(name="fk_ownership_change_requests_file_transfer_request_idx", columns={"file_transfer_request_id"}),
 *         @ORM\Index(name="fk_ownership_change_requests_user_sender_idx", columns={"sender_id"}),
 *         @ORM\Index(name="fk_ownership_change_requests_user_receiver_idx", columns={"receiver_id"})
 *     }
 * )
 * @ORM\Entity
 */
class OwnershipChangeRequest extends AbstractDataObject
{

    /** @var string */
    const STATUS_PENDING = 'pending';
    /** @var string */
    const STATUS_RECALLED = 'recalled';
    /** @var string */
    const STATUS_ACCEPTED = 'accepted';
    /** @var string */
    const STATUS_DECLINED = 'declined';

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
     * @ORM\Column(name="sender_email", type="string", length=50, nullable=true)
     */
    protected $senderEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_email", type="string", length=50, nullable=true)
     */
    protected $receiverEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    protected $status;

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
     * @var FileTransferRequest
     *
     * @ORM\ManyToOne(targetEntity="FileTransferRequest")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_transfer_request_id", referencedColumnName="id")
     * })
     */
    private $fileTransferRequest;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     * })
     */
    private $receiver;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     * })
     */
    private $sender;

    /**
     * @param integer $id
     *
     * @return OwnershipChangeRequest
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
     * @param string $senderEmail
     *
     * @return OwnershipChangeRequest
     */
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }

    /**
     * @param string $receiverEmail
     *
     * @return OwnershipChangeRequest
     */
    public function setReceiverEmail($receiverEmail)
    {
        $this->receiverEmail = $receiverEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getReceiverEmail()
    {
        return $this->receiverEmail;
    }

    /**
     * @param string $status
     *
     * @return OwnershipChangeRequest
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
     * @param \DateTime $created
     *
     * @return OwnershipChangeRequest
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
     * @return OwnershipChangeRequest
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
     * @param FileTransferRequest $fileTransferRequest
     *
     * @return OwnershipChangeRequest
     */
    public function setFileTransferRequest(FileTransferRequest $fileTransferRequest = null)
    {
        $this->fileTransferRequest = $fileTransferRequest;
        return $this;
    }

    /**
     * @return FileTransferRequest
     */
    public function getFileTransferRequest()
    {
        return $this->fileTransferRequest;
    }

    /**
     * @param User $receiver
     *
     * @return OwnershipChangeRequest
     */
    public function setReceiver(User $receiver = null)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param User $sender
     *
     * @return OwnershipChangeRequest
     */
    public function setSender(User $sender = null)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

}
