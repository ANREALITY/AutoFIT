<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DbSystel\Annotation\Export;

/**
 * ServiceInvoice
 *
 * @ORM\Table(
 *     name="service_invoice",
 *     indexes={
 *         @ORM\Index(name="fk_service_invoice_application_idx", columns={"application_technical_short_name"}),
 *         @ORM\Index(name="fk_service_invoice_environment_idx", columns={"environment_severity"})
 *     }
 * )
 * @ORM\Entity(readOnly=true)
 */
class ServiceInvoice extends AbstractDataObject
{

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=16, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $number;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    protected $description;

    /**
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_technical_short_name", referencedColumnName="technical_short_name")
     * })
     */
    protected $application;

    /**
     * @var Environment
     *
     * @ORM\ManyToOne(targetEntity="Environment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="environment_severity", referencedColumnName="severity")
     * })
     */
    protected $environment;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ServiceInvoicePosition", mappedBy="serviceInvoice")
     */
    protected $serviceInvoicePositions;

    public function __construct()
    {
        $this->serviceInvoicePositions = new ArrayCollection();
    }

    /**
     * @param string $number
     *
     * @return ServiceInvoice
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
     * @param string $description
     *
     * @return ServiceInvoice
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
     * @param Application $application
     *
     * @return ServiceInvoice
     */
    public function setApplication(Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Environment $environment
     *
     * @return ServiceInvoice
     */
    public function setEnvironment(Environment $environment = null)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param ServiceInvoicePosition[] $serviceInvoicePositions
     *
     * @return ServiceInvoice
     */
    public function setServiceInvoicePositions($serviceInvoicePositions)
    {
        $this->serviceInvoicePositions = $serviceInvoicePositions;
        return $this;
    }

    /**
     * @return ServiceInvoicePosition[] $serviceInvoicePositions
     */
    public function getServiceInvoicePositions()
    {
        return $this->serviceInvoicePositions;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePosition
     * @return ServiceInvoice
     */
    public function addServiceInvoicePosition(ServiceInvoicePosition $serviceInvoicePosition)
    {
        $this->serviceInvoicePositions->add($serviceInvoicePosition);
        return $this;
    }

    /**
     * @param ServiceInvoicePosition $serviceInvoicePosition
     * @return ServiceInvoice
     */
    public function removeServiceInvoicePosition(ServiceInvoicePosition $serviceInvoicePosition)
    {
        $this->serviceInvoicePositions->removeElement($serviceInvoicePosition);
        return $this;
    }

}
