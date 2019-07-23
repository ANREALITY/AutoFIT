<?php
namespace Base\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(readOnly=true)
 */
class Application extends AbstractDataObject
{

    /**
     * @var string
     *
     * @ORM\Column(name="technical_short_name", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     *
     * @Groups({"export"})
     */
    protected $technicalShortName;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_id", type="string", length=10, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $technicalId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $active;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ServiceInvoice", mappedBy="application")
     */
    protected $serviceInvoices;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    public function __construct()
    {
        $this->serviceInvoices = new ArrayCollection();
    }

    /**
     * @param string $technicalShortName
     *
     * @return Application
     */
    public function setTechnicalShortName($technicalShortName)
    {
        $this->technicalShortName = $technicalShortName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTechnicalShortName()
    {
        return $this->technicalShortName;
    }

    /**
     * @param string $technicalId
     *
     * @return Application
     */
    public function setTechnicalId($technicalId)
    {
        $this->technicalId = $technicalId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTechnicalId()
    {
        return $this->technicalId;
    }

    /**
     * @param boolean $active
     *
     * @return Application
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param ArrayCollection $serviceInvoices
     *
     * @return Application
     */
    public function setServiceInvoices($serviceInvoices)
    {
        $this->serviceInvoices = $serviceInvoices;
        return $this;
    }

    /**
     * @return ArrayCollection $serviceInvoices
     */
    public function getServiceInvoices()
    {
        return $this->serviceInvoices;
    }

    /**
     * @param ServiceInvoice $serviceInvoice
     * @return Application
     */
    public function addServiceInvoice(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoices->add($serviceInvoice);
        return $this;
    }

    /**
     * @param ServiceInvoice $serviceInvoice
     * @return Application
     */
    public function removeServiceInvoice(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoices->removeElement($serviceInvoice);
        return $this;
    }

    /**
     * @param \DateTime $updated
     *
     * @return Application
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
