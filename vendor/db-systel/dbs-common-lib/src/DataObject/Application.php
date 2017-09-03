<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use DbSystel\Annotation\Export;

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
     */
    protected $technicalShortName;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_id", type="string", length=10, nullable=true)
     */
    protected $technicalId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

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
