<?php
namespace DbSystel\DataObject;

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
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $changeNumber;

    /**
     *
     * @var string
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $comment;

    /**
     *
     * @var string
     */
    protected $created;

    /**
     *
     * @var string
     */
    protected $updated;

    /**
     *
     * @var LogicalConnection
     */
    protected $logicalConnection;

    /**
     *
     * @var ServiceInvoicePosition
     */
    protected $serviceInvoicePositionBasic;

    /**
     *
     * @var ServiceInvoicePosition
     */
    protected $serviceInvoicePositionPersonal;

    /**
     *
     * @var User
     */
    protected $user;

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $changeNumber
     */
    public function setChangeNumber($changeNumber)
    {
        $this->changeNumber = $changeNumber;
    }

    /**
     *
     * @return string $changeNumber
     */
    public function getChangeNumber()
    {
        return $this->changeNumber;
    }

    /**
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     *
     * @param string $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     *
     * @return string $created
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     *
     * @param string $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     *
     * @return string $updated
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     *
     * @param LogicalConnection $logicalConnection
     */
    public function setLogicalConnection($logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;
    }

    /**
     *
     * @return LogicalConnection $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     *
     * @param ServiceInvoicePosition $serviceInvoicePositionBasic
     */
    public function setServiceInvoicePositionBasic($serviceInvoicePositionBasic)
    {
        $this->serviceInvoicePositionBasic = $serviceInvoicePositionBasic;
    }

    /**
     *
     * @return ServiceInvoicePosition $serviceInvoicePositionBasic
     */
    public function getServiceInvoicePositionBasic()
    {
        return $this->serviceInvoicePositionBasic;
    }

    /**
     *
     * @param ServiceInvoicePosition $serviceInvoicePositionPersonal
     */
    public function setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal)
    {
        $this->serviceInvoicePositionPersonal = $serviceInvoicePositionPersonal;
    }

    /**
     *
     * @return ServiceInvoicePosition $serviceInvoicePositionPersonal
     */
    public function getServiceInvoicePositionPersonal()
    {
        return $this->serviceInvoicePositionPersonal;
    }

    /**
     *
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *
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
