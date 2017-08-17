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
     * @return integer $severity
     */
    public function getSeverity()
    {
        return $this->severity;
    }

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
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
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
     * @return string $shortName
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     *
     * @param string $shortName
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

}