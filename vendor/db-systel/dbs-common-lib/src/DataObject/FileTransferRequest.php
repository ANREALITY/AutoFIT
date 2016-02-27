<?php
namespace DbSystel\DataObject;

class FileTransferRequest
{

    /**
     *
     * @var int
     */
    protected $id;

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
     * @return the $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     *
     * @param \DbSystel\DataObject\LogicalConnection $logicalConnection            
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
     * @param \DbSystel\DataObject\ServiceInvoicePosition $serviceInvoicePositionBasic            
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
     * @param \DbSystel\DataObject\ServiceInvoicePosition $serviceInvoicePositionPersonal            
     */
    public function setServiceInvoicePositionPersonal($serviceInvoicePositionPersonal)
    {
        $this->serviceInvoicePositionPersonal = $serviceInvoicePositionPersonal;
    }
}
