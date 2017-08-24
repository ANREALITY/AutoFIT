<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EndpointType
 *
 * @ORM\Table(name="endpoint_type")
 * @ORM\Entity(readOnly=true)
 */
class EndpointType extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=true)
     */
    private $label;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="ServerType", mappedBy="endpointTypes")
     */
    private $serverTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->serverType = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return EndpointType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return EndpointType
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
     * @param string $label
     *
     * @return EndpointType
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add serverType
     *
     * @param ServerType $serverType
     *
     * @return EndpointType
     */
    public function addServerType(ServerType $serverType)
    {
        $this->serverTypes[] = $serverType;

        return $this;
    }

    /**
     * Remove serverType
     *
     * @param ServerType $serverType
     */
    public function removeServerType(ServerType $serverType)
    {
        $this->serverTypes->removeElement($serverType);
    }

    /**
     * @return Collection
     */
    public function getServerTypes()
    {
        return $this->serverTypes;
    }

}
