<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceInvoicePosition
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
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $orderQuantity;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $status;

    /**
     * @var ServiceInvoice
     */
    private $serviceInvoice;

    /**
     * @var Article
     */
    private $article;

    /**
     * @param string $number
     * @return ServiceInvoicePosition
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $orderQuantity
     * @return ServiceInvoicePosition
     */
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = $orderQuantity;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderQuantity()
    {
        return $this->orderQuantity;
    }

    /**
     * @param string $description
     * @return ServiceInvoicePosition
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $status
     * @return ServiceInvoicePosition
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
     * @param \DbSystel\DataObject\ServiceInvoice $serviceInvoice
     */
    public function setServiceInvoice($serviceInvoice)
    {
        $this->serviceInvoice = $serviceInvoice;

        return $this;
    }

    /**
     * @return ServiceInvoice $serviceInvoice
     */
    public function getServiceInvoice()
    {
        return $this->serviceInvoice;
    }

    /**
     * @param \DbSystel\DataObject\Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return Article $article
     */
    public function getArticle()
    {
        return $this->article;
    }

}