<?php
namespace DbSystel\DataObject;

/**
 * Class ServiceInvoicePosition
 *
 * @package DbSystel\DataObject
 */
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
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

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
     * @param string $orderQuantity
     */
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = $orderQuantity;

        return $this;
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
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
     * @param \DbSystel\DataObject\ServiceInvoice $serviceInvoice
     */
    public function setServiceInvoice($serviceInvoice)
    {
        $this->serviceInvoice = $serviceInvoice;

        return $this;
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
     * @param \DbSystel\DataObject\Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     *
     * @return Article $article
     */
    public function getArticle()
    {
        return $this->article;
    }

}