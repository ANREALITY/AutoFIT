<?php
namespace DbSystel\DataObject;

class Environment extends AbstractDataObject
{

    /**
     *
     * @var integer
     */
    protected $severity;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $shortName;

    /**
     *
     * @param number $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    /**
     *
     * @return integer $severity
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     *
     * @return string $shortName
     */
    public function getShortName()
    {
        return $this->shortName;
    }

}