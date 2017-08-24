<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServerType
 *
 * @ORM\Table(name="server_type", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})})
 * @ORM\Entity
 */
class ServerType extends AbstractDataObject
{

    /**
     * @var boolean
     *
     * @ORM\Column(name="id", type="boolean", nullable=false)
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="EndpointType", inversedBy="serverTypes")
     * @ORM\JoinTable(name="endpoint_type_server_type",
     *   joinColumns={
     *     @ORM\JoinColumn(name="server_type_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="endpoint_type_id", referencedColumnName="id")
     *   }
     * )
     */
    private $endpointTypes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->endpointType = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return boolean
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEndpointTypes()
    {
        return $this->endpointTypes;
    }

}
