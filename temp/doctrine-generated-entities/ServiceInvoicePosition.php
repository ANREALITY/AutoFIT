<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceInvoicePosition
 *
 * @ORM\Table(name="service_invoice_position", indexes={@ORM\Index(name="fk_service_invoice_position_service_invoice_idx", columns={"service_invoice_number"}), @ORM\Index(name="fk_service_invoice_position_article1_idx", columns={"article_sku"})})
 * @ORM\Entity
 */
class ServiceInvoicePosition extends AbstractDataObject
{
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="order_quantity", type="string", length=12, nullable=true)
     */
    private $orderQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_sku", referencedColumnName="sku")
     * })
     */
    private $articleSku;

    /**
     * @var ServiceInvoice
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_number", referencedColumnName="number")
     * })
     */
    private $serviceInvoiceNumber;



    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $orderQuantity
     *
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
     *
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
     *
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
     * @param \DateTime $updated
     *
     * @return ServiceInvoicePosition
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param Article $articleSku
     *
     * @return ServiceInvoicePosition
     */
    public function setArticleSku(\Article $articleSku = null)
    {
        $this->articleSku = $articleSku;

        return $this;
    }

    /**
     * @return Article
     */
    public function getArticleSku()
    {
        return $this->articleSku;
    }

    /**
     * @param ServiceInvoice $serviceInvoiceNumber
     *
     * @return ServiceInvoicePosition
     */
    public function setServiceInvoiceNumber(\ServiceInvoice $serviceInvoiceNumber = null)
    {
        $this->serviceInvoiceNumber = $serviceInvoiceNumber;

        return $this;
    }

    /**
     * @return ServiceInvoice
     */
    public function getServiceInvoiceNumber()
    {
        return $this->serviceInvoiceNumber;
    }
}
