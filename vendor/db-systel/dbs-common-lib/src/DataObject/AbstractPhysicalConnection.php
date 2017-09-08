<?php
namespace DbSystel\DataObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * AbstractPhysicalConnection
 *
 * @ORM\Table(
 *     name="physical_connection",
 *     indexes={
 *         @ORM\Index(name="fk_physical_connection_logical_connection_idx", columns={"logical_connection_id"})
 *     }
 * )
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="role", type="string")
 * @ORM\DiscriminatorMap({
 *     "end_to_end" = "PhysicalConnectionCdEndToEnd",
 *     "end_to_middle" = "PhysicalConnectionFtgwEndToMiddle",
 *     "middle_to_end" = "PhysicalConnectionFtgwMiddleToEnd"
 * })
 */
abstract class AbstractPhysicalConnection extends AbstractDataObject
{

    /** @var string */
    const ROLE_END_TO_END = 'end_to_end';
    /** @var string */
    const ROLE_END_TO_MIDDLE = 'end_to_middle';
    /** @var string */
    const ROLE_MIDDLE_TO_END = 'middle_to_end';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="secure_plus", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $securePlus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @var LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection", inversedBy="physicalConnections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    protected $logicalConnection;

    /**
     * @var AbstractEndpoint #relationshipInversion
     *
     * @Groups({"export"})
     */
    protected $endpointSource;

    /**
     * @var AbstractEndpoint #relationshipInversion
     *
     * @Groups({"export"})
     */
    protected $endpointTarget;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AbstractEndpoint", mappedBy="physicalConnection")
     */
    protected $endpoints;

    public function __construct()
    {
        $this->endpoints = new ArrayCollection();
    }

    /**
     * @param integer $id
     *
     * @return AbstractPhysicalConnection
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
     * @param string $role
     *
     * @return AbstractPhysicalConnection
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        $role = null;
        switch (get_class($this)) {
            case PhysicalConnectionCdEndToEnd::class:
                $role = self::ROLE_END_TO_END;
                break;
            case PhysicalConnectionFtgwEndToMiddle::class:
                $role = self::ROLE_END_TO_MIDDLE;
                break;
            case PhysicalConnectionFtgwMiddleToEnd::class:
                $role = self::ROLE_MIDDLE_TO_END;
                break;
        }
        return $role;
    }

    /**
     * @param string $type
     *
     * @return AbstractPhysicalConnection
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param boolean $securePlus
     *
     * @return AbstractPhysicalConnection
     */
    public function setSecurePlus($securePlus)
    {
        $this->securePlus = $securePlus;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSecurePlus()
    {
        return $this->securePlus;
    }

    /**
     * @param string $created
     *
     * @return AbstractPhysicalConnection
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $updated
     *
     * @return AbstractPhysicalConnection
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param LogicalConnection $logicalConnection
     *
     * @return AbstractPhysicalConnection
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * @return LogicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     * @param AbstractEndpoint $endpointSource
     *
     * @return AbstractPhysicalConnection
     */
    public function setEndpointSource($endpointSource)
    {
        $this->endpointSource = $endpointSource;
        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpointSource()
    {
        if (! $this->endpointSource) {
            $this->endpointSource = $this->getFirstInstanceByDiscriminator(
                $this->getEndpoints(), 'getRole', AbstractEndpoint::ROLE_SOURCE
            );
        }
        return $this->endpointSource;
    }

    /**
     * @param AbstractEndpoint $endpointTarget
     *
     * @return AbstractPhysicalConnection
     */
    public function setEndpointTarget($endpointTarget)
    {
        $this->endpointTarget = $endpointTarget;
        return $this;
    }

    /**
     * @return AbstractEndpoint
     */
    public function getEndpointTarget()
    {
        if (! $this->endpointTarget) {
            $this->endpointTarget = $this->getFirstInstanceByDiscriminator(
                $this->getEndpoints(), 'getRole', AbstractEndpoint::ROLE_TARGET
            );
        }
        return $this->endpointTarget;
    }

    /**
     * @param AbstractEndpoint[] $endpoints
     * @return AbstractPhysicalConnection
     */
    public function setEndpoints(array $endpoints)
    {
        $this->endpoints = $endpoints;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return AbstractPhysicalConnection
     */
    public function addEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoints->add($endpoint);
        return $this;
    }

    /**
     * @param AbstractEndpoint $endpoint
     * @return AbstractPhysicalConnection
     */
    public function removeEndpoint(AbstractEndpoint $endpoint)
    {
        $this->endpoints->removeElement($endpoint);
        return $this;
    }

    /**
     * Iterates over the given array and
     * returns the first instance of the given type found.
     *
     * @param $list
     * @param string $discriminatorGetter
     * @param $discriminatorValue
     * @return null
     */
    protected function getFirstInstanceByDiscriminator($list, string $discriminatorGetter, $discriminatorValue)
    {
        $return = null;
        foreach ($list as $element) {
            if ($element->$discriminatorGetter() === $discriminatorValue) {
                $return = $element;
                break;
            }
        }
        return $return;
    }

}
