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
     * @var int
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
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

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
     * @return the $changeNumber
     */
    public function getChangeNumber()
    {
        return $this->changeNumber;
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
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
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
     * @return the $comment
     */
    public function getComment()
    {
        return $this->comment;
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
     * @return the $created
     */
    public function getCreated()
    {
        return $this->created;
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
     * @return the $updated
     */
    public function getUpdated()
    {
        return $this->updated;
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
     * @return the $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
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
     * @return the $serviceInvoicePositionBasic
     */
    public function getServiceInvoicePositionBasic()
    {
        return $this->serviceInvoicePositionBasic;
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
     * @return the $serviceInvoicePositionPersonal
     */
    public function getServiceInvoicePositionPersonal()
    {
        return $this->serviceInvoicePositionPersonal;
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
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function exchangeArray()
    {
        return get_object_vars($this);
    }

}
