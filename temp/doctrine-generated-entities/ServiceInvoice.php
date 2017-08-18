<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceInvoice
 *
 * @ORM\Table(name="service_invoice", indexes={@ORM\Index(name="fk_service_invoice_application_idx", columns={"application_technical_short_name"}), @ORM\Index(name="fk_service_invoice_environment_idx", columns={"environment_severity"})})
 * @ORM\Entity
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
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    private $description;

    /**
     * @var \Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_technical_short_name", referencedColumnName="technical_short_name")
     * })
     */
    private $applicationTechnicalShortName;

    /**
     * @var \Environment
     *
     * @ORM\ManyToOne(targetEntity="Environment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="environment_severity", referencedColumnName="severity")
     * })
     */
    private $environmentSeverity;



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
     * @param \Application $applicationTechnicalShortName
     *
     * @return ServiceInvoice
     */
    public function setApplicationTechnicalShortName(\Application $applicationTechnicalShortName = null)
    {
        $this->applicationTechnicalShortName = $applicationTechnicalShortName;

        return $this;
    }

    /**
     * @return \Application
     */
    public function getApplicationTechnicalShortName()
    {
        return $this->applicationTechnicalShortName;
    }

    /**
     * @param \Environment $environmentSeverity
     *
     * @return ServiceInvoice
     */
    public function setEnvironmentSeverity(\Environment $environmentSeverity = null)
    {
        $this->environmentSeverity = $environmentSeverity;

        return $this;
    }

    /**
     * @return \Environment
     */
    public function getEnvironmentSeverity()
    {
        return $this->environmentSeverity;
    }
}
