<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ServerType
 *
 * @ORM\Table(
 *     name="server_type",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})
 *     }
 * )
 * @ORM\Entity
 */
class ServerType extends AbstractDataObject
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
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="EndpointType", inversedBy="serverTypes")
     * @ORM\JoinTable(
     *     name="endpoint_type_server_type",
     *     joinColumns={
     *         @ORM\JoinColumn(name="server_type_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="endpoint_type_id", referencedColumnName="id")
     *     }
     * )
     */
    private $endpointTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->endpointType = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return ServerType
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
     * @return ServerType
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
     * Add endpointType
     *
     * @param EndpointType $endpointType
     *
     * @return ServerType
     */
    public function addEndpointType(EndpointType $endpointType)
    {
        $this->endpointTypes[] = $endpointType;

        return $this;
    }

    /**
     * Remove endpointType
     *
     * @param EndpointType $endpointType
     */
    public function removeEndpointType(EndpointType $endpointType)
    {
        $this->endpointTypes->removeElement($endpointType);
    }

    /**
     * @return Collection
     */
    public function getEndpointTypes()
    {
        return $this->endpointTypes;
    }

}
