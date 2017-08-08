<?php
namespace DbSystel\DataObject;

class ServiceInvoicePosition extends AbstractDataObject
{

    const STATUS_ACTIVE = 'Aktiv';
    const STATUS_COMPLETED = 'Beendet';
    const STATUS_SUPPLYING_INITIATED = 'Bereitstellung ausgelost';
    const STATUS_SUPPLYING_ORDERED = 'Bereitstellung beauftragt';
    const STATUS_IN_PREPARATION = 'In Vorbereitung';
    const STATUS_HARWARE_SUPPLIED = 'Technik bereitgestellt';

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
     * @return string $number
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
     * @return string $orderQuantity
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
     * @return string $description
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
     * @return string $status
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
     * @return ServiceInvoice $serviceInvoice
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
     * @return Article $article
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