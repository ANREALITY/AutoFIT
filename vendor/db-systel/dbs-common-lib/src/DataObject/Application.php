<?php
namespace DbSystel\DataObject;

class Application extends AbstractDataObject
{

    /**
     *
     * @var string
     */
    protected $technicalShortName;

    /**
     *
     * @var string
     */
    protected $technicalId;

    /**
     *
     * @var boolean
     */
    protected $active;

    /**
     *
     * @param string $technicalShortName
     */
    public function setTechnicalShortName($technicalShortName)
    {
        $this->technicalShortName = $technicalShortName;
    }

    /**
     *
     * @return string $technicalShortName
     */
    public function getTechnicalShortName()
    {
        return $this->technicalShortName;
    }

    /**
     *
     * @param string $technicalId
     */
    public function setTechnicalId($technicalId)
    {
        $this->technicalId = $technicalId;
    }

    /**
     *
     * @return string $technicalId
     */
    public function getTechnicalId()
    {
        return $this->technicalId;
    }

    /**
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }

}