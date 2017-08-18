<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Environment
 *
 * @ORM\Table(name="environment")
 * @ORM\Entity
 */
class Environment extends AbstractDataObject
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="severity", type="boolean", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $severity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=1, nullable=false)
     */
    private $shortName;



    /**
     * @return boolean
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
}
