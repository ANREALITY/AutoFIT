<?php
namespace DbSystel\DataObject;

/**
 * Class Environment
 *
 * @package DbSystel\DataObject
 */
class Environment extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $severity;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortName;

    /**
     * @param integer $severity
     * @return Environment
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * @return integer $severity
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @param string $name
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

}