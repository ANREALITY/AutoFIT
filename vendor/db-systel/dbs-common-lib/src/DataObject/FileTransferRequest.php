<?php
namespace DbSystel\DataObject;

/**
 * FileTransferRequest
 *
 * @package DbSystel\DataObject
 */
class FileTransferRequest extends AbstractDataObject
{

    const STATUS_EDIT = 'edit';

    const STATUS_PENDING = 'pending';

    const STATUS_CANCELED = 'canceled';

    const STATUS_CHECK = 'check';

    const STATUS_ACCEPTED = 'accepted';

    const STATUS_DECLINED = 'declined';

    const STATUS_COMPLETED = 'completed';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $changeNumber;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $created;

    /**
     * @var string
     */
    private $updated;

    /**
     * @var LogicalConnection
     */
    private $logicalConnection;

    /**
     * @var ServiceInvoicePosition
     */
    private $serviceInvoicePositionBasic;

    /**
     * @var ServiceInvoicePosition
     */
    private $serviceInvoicePositionPersonal;

    /**
     * @var User
     */
    private $user;

    /**
     * @param integer $id
     * @return FileTransferRequest
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
     * @param string $changeNumber
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
     * @param string $created
     * @return FileTransferRequest
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
     * @return FileTransferRequest
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
     * @param LogicalConnection $logicalConnection
     * @return FileTransferRequest
     */
    public function setLogicalConnection($logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * @return LogicalConnection $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePositionBasic
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionBasic($serviceInvoicePositionBasic)
    {
        $this->serviceInvoicePositionBasic = $serviceInvoicePositionBasic;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition $serviceInvoicePositionBasic
     */
    public function getServiceInvoicePositionBasic()
    {
        return $this->serviceInvoicePositionBasic;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePositionPersonal
     * @return FileTransferRequest
     */
    public function setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal)
    {
        $this->serviceInvoicePositionPersonal = $serviceInvoicePositionPersonal;

        return $this;
    }

    /**
     * @return ServiceInvoicePosition $serviceInvoicePositionPersonal
     */
    public function getServiceInvoicePositionPersonal()
    {
        return $this->serviceInvoicePositionPersonal;
    }

    /**
     * @param User $user
     * @return FileTransferRequest
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User $user
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
