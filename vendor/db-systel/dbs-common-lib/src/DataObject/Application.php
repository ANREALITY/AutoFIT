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
     * @return the $technicalShortName
     */
    public function getTechnicalShortName()
    {
        return $this->technicalShortName;
    }

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
     * @return the $technicalId
     */
    public function getTechnicalId()
    {
        return $this->technicalId;
    }

    /**
     *
     * @param string $technicalId
     */
    public function setTechnicalId($technicalId)
    {
        $this->technicalId = $technicalId;
    }

}