<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 */
class Application extends AbstractDataObject
{

    /**
     * @var string
     */
    private $technicalShortName;

    /**
     * @var string
     */
    private $technicalId;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @param string $technicalShortName
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

}