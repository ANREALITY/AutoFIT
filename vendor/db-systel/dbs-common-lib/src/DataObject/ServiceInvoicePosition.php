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
     * @var string
     */
    protected $status;

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
     * @return the $serviceInvoice
     */
    public function getServiceInvoice()
    {
        return $this->serviceInvoice;
    }

    /**
     *
     * @param \DbSystel\DataObject\ServiceInvoice $serviceInvoice
     */
    public function setServiceInvoice($serviceInvoice)
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
     * @param \DbSystel\DataObject\Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

}