<?php
namespace DbSystel\DataObject;

class FileTransferRequest extends AbstractDataObject
{

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

}
