<?php
namespace DbSystel\DataObject;

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
 */
class ServiceInvoicePosition extends AbstractDataObject
{

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
    private $fileTransferRequests;

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
     * @param ServiceInvoice $serviceInvoice
     *
     * @return ServiceInvoicePosition
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
     * @param AbstractArticle $article
     *
     * @return ServiceInvoicePosition
     */
    public function setArticle(AbstractArticle $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return AbstractArticle
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param FileTransferRequest[] $fileTransferRequests
     * @return ServiceInvoicePosition
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
     * @return ServiceInvoicePosition
     */
    public function addFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequests->add($fileTransferRequest);
        return $this;
    }

    /**
     * @param FileTransferRequest $fileTransferRequest
     * @return ServiceInvoicePosition
     */
    public function removeFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequests->removeElement($fileTransferRequest);
        return $this;
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

}
