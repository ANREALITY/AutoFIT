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
     * @param integer $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
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

        return $this;
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

        return $this;
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