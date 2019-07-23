<?php
namespace Base\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * ServiceInvoicePosition
 *
 * @ORM\Table(
 *     name="service_invoice_position",
 *     indexes={
 *         @ORM\Index(name="fk_service_invoice_position_service_invoice_idx", columns={"service_invoice_number"}),
 *         @ORM\Index(name="fk_service_invoice_position_article1_idx", columns={"article_sku"})
 *     }
 * )
 * @ORM\Entity(readOnly=true)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "basic" = "ServiceInvoicePositionBasic",
 *     "personal" = "ServiceInvoicePositionPersonal",
 *     "on-demand" = "ServiceInvoicePositionOnDemand"
 * })
 */
abstract class AbstractServiceInvoicePosition extends AbstractDataObject
{

    /** @var string */
    const TYPE_BASIC = 'basic';
    /** @var string */
    const TYPE_PERSONAL = 'personal';
    /** @var string */
    const TYPE_ON_DEMAND = 'on-demand';
    /** @var string */
    const STATUS_ACTIVE = 'Aktiv';
    /** @var string */
    const STATUS_COMPLETED = 'Beendet';
    /** @var string */
    const STATUS_SUPPLYING_INITIATED = 'Bereitstellung ausgelost';
    /** @var string */
    const STATUS_SUPPLYING_ORDERED = 'Bereitstellung beauftragt';
    /** @var string */
    const STATUS_IN_PREPARATION = 'In Vorbereitung';
    /** @var string */
    const STATUS_HARWARE_SUPPLIED = 'Technik bereitgestellt';

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @Groups({"export"})
     */
    protected $number;

    /**
     * @var string
     *
     * @ORM\Column(name="order_quantity", type="string", length=12, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $orderQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=32, nullable=false)
     *
     * @Groups({"export"})
     */
    protected $status;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var ServiceInvoice
     *
     * @ORM\ManyToOne(targetEntity="ServiceInvoice", inversedBy="serviceInvoicePositions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_invoice_number", referencedColumnName="number")
     * })
     *
     * @Groups({"export"})
     */
    protected $serviceInvoice;

    /**
     * @var AbstractArticle
     *
     * @ORM\ManyToOne(targetEntity="AbstractArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_sku", referencedColumnName="sku")
     * })
     *
     * @Groups({"export"})
     */
    protected $article;

    /**
     * @ORM\ManyToMany(targetEntity="FileTransferRequest", mappedBy="serviceInvoicePositions")
     */
    protected $fileTransferRequests;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    public function __construct() {
        $this->fileTransferRequests = new ArrayCollection();
    }

    /**
     * @param string $number
     *
     * @return AbstractServiceInvoicePosition
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
     *
     * @return AbstractServiceInvoicePosition
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
     * @return AbstractServiceInvoicePosition
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
     * @return AbstractServiceInvoicePosition
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
     * @param string $type
     *
     * @return AbstractServiceInvoicePosition
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        $type = $this->type ?: null;
        switch(get_class($this)) {
            case ServiceInvoicePositionBasic::class:
                $type = self::TYPE_BASIC;
                break;
            case ServiceInvoicePositionPersonal::class:
                $type = self::TYPE_PERSONAL;
                break;
            case ServiceInvoicePositionOnDemand::class:
                $type = self::TYPE_ON_DEMAND;
                break;
        }
        return $type;
    }

    /**
     * @param ServiceInvoice $serviceInvoice
     *
     * @return AbstractServiceInvoicePosition
     */
    public function setServiceInvoice(ServiceInvoice $serviceInvoice = null)
    {
        $this->serviceInvoice = $serviceInvoice;
        return $this;
    }

    /**
     * @return ServiceInvoice
     */
    public function getServiceInvoice()
    {
        return $this->serviceInvoice;
    }

    /**
     * @param FileTransferRequest[] $fileTransferRequests
     * @return AbstractServiceInvoicePosition
     */
    public function setFileTransferRequests($fileTransferRequests)
    {
        $this->fileTransferRequests = new ArrayCollection([]);
        /** @var AbstractEndpoint $endpoint */
        foreach ($fileTransferRequests as $fileTransferRequest) {
            $this->addFileTransferRequest($fileTransferRequest);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $fileTransferRequests
     */
    public function getFileTransferRequests()
    {
        return $this->fileTransferRequests;
    }

    /**
     * @param FileTransferRequest $fileTransferRequest
     * @return AbstractServiceInvoicePosition
     */
    public function addFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequests->add($fileTransferRequest);
        return $this;
    }

    /**
     * @param FileTransferRequest $fileTransferRequest
     * @return AbstractServiceInvoicePosition
     */
    public function removeFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequests->removeElement($fileTransferRequest);
        return $this;
    }

    /**
     * @param \DateTime $updated
     *
     * @return AbstractServiceInvoicePosition
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

}
