<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Environment
 *
 * @ORM\Table(name="environment")
 * @ORM\Entity(readOnly=true)
 */
class Environment extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="severity", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $severity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     *
     * @Groups({"export"})
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=1, nullable=false)
     */
    protected $shortName;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ServiceInvoice", mappedBy="environment")
     */
    protected $serviceInvoices;

    /**
     * @param integer $severity
     *
     * @return Environment
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * @return integer
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @param string $name
     *
     * @return Environment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $shortName
     *
     * @return Environment
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param ServiceInvoice[] $serviceInvoices
     *
     * @return Environment
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
     * @return Environment
     */
    public function addServiceInvoice(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoices->add($serviceInvoice);
        return $this;
    }

    /**
     * @param ServiceInvoice $serviceInvoice
     * @return Environment
     */
    public function removeServiceInvoice(ServiceInvoice $serviceInvoice)
    {
        $this->serviceInvoices->removeElement($serviceInvoice);
        return $this;
    }

}
