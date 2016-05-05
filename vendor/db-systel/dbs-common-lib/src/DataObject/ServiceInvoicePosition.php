<?php
namespace DbSystel\DataObject;

class ServiceInvoicePosition extends AbstractDataObject
{

    /**
     *
     * @var string
     */
    protected $number;

    /**
     *
     * @var string
     */
    protected $orderQuantity;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var ServiceInvoice
     */
    protected $serviceInvoice;

    /**
     *
     * @var Article
     */
    protected $article;

    /**
     *
     * @var ServiceInvoicePositionStatus
     */
    protected $serviceInvoicePositionStatus;

    /**
     *
     * @return the $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     *
     * @param string $number            
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     *
     * @return the $orderQuantity
     */
    public function getOrderQuantity()
    {
        return $this->orderQuantity;
    }

    /**
     *
     * @param string $orderQuantity            
     */
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = $orderQuantity;
    }

    /**
     *
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description            
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @return the $serviceInvoice
     */
    public function getServiceInvoice()
    {
        return $this->serviceInvoice;
    }

    /**
     *
     * @param ServiceInvoice $serviceInvoice            
     */
    public function setServiceInvoice(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoice = $serviceInvoice;
    }

    /**
     *
     * @return the $article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     *
     * @param Article $article            
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     *
     * @return the $serviceInvoicePositionStatus
     */
    public function getServiceInvoicePositionStatus()
    {
        return $this->serviceInvoicePositionStatus;
    }

    /**
     *
     * @param ServiceInvoicePositionStatus $serviceInvoicePositionStatus            
     */
    public function setServiceInvoicePositionStatus(ServiceInvoicePositionStatus $serviceInvoicePositionStatus)
    {
        $this->serviceInvoicePositionStatus = $serviceInvoicePositionStatus;
    }

}