<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Endpoint
 *
 * @ORM\Table(name="endpoint", indexes={@ORM\Index(name="fk_endpoint_physical_connection_idx", columns={"physical_connection_id"}), @ORM\Index(name="fk_endpoint_application_idx", columns={"application_technical_short_name"}), @ORM\Index(name="fk_endpoint_customer_idx", columns={"customer_id"}), @ORM\Index(name="fk_endpoint_endpoint_server_config_idx", columns={"endpoint_server_config_id"}), @ORM\Index(name="fk_endpoint_external_server_idx", columns={"external_server_id"})})
 * @ORM\Entity
 */
class Endpoint
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
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="server_place", type="string", nullable=true)
     */
    private $serverPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_person", type="string", length=500, nullable=true)
     */
    private $contactPerson;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var \Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_technical_short_name", referencedColumnName="technical_short_name")
     * })
     */
    private $applicationTechnicalShortName;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var \EndpointServerConfig
     *
     * @ORM\ManyToOne(targetEntity="EndpointServerConfig")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_server_config_id", referencedColumnName="id")
     * })
     */
    private $endpointServerConfig;

    /**
     * @var \ExternalServer
     *
     * @ORM\ManyToOne(targetEntity="ExternalServer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="external_server_id", referencedColumnName="id")
     * })
     */
    private $externalServer;

    /**
     * @var \PhysicalConnection
     *
     * @ORM\ManyToOne(targetEntity="PhysicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="physical_connection_id", referencedColumnName="id")
     * })
     */
    private $physicalConnection;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Endpoint
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Endpoint
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set serverPlace
     *
     * @param string $serverPlace
     *
     * @return Endpoint
     */
    public function setServerPlace($serverPlace)
    {
        $this->serverPlace = $serverPlace;

        return $this;
    }

    /**
     * Get serverPlace
     *
     * @return string
     */
    public function getServerPlace()
    {
        return $this->serverPlace;
    }

    /**
     * Set contactPerson
     *
     * @param string $contactPerson
     *
     * @return Endpoint
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * Get contactPerson
     *
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Endpoint
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Endpoint
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set applicationTechnicalShortName
     *
     * @param \Application $applicationTechnicalShortName
     *
     * @return Endpoint
     */
    public function setApplicationTechnicalShortName(\Application $applicationTechnicalShortName = null)
    {
        $this->applicationTechnicalShortName = $applicationTechnicalShortName;

        return $this;
    }

    /**
     * Get applicationTechnicalShortName
     *
     * @return \Application
     */
    public function getApplicationTechnicalShortName()
    {
        return $this->applicationTechnicalShortName;
    }

    /**
     * Set customer
     *
     * @param \Customer $customer
     *
     * @return Endpoint
     */
    public function setCustomer(\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set endpointServerConfig
     *
     * @param \EndpointServerConfig $endpointServerConfig
     *
     * @return Endpoint
     */
    public function setEndpointServerConfig(\EndpointServerConfig $endpointServerConfig = null)
    {
        $this->endpointServerConfig = $endpointServerConfig;

        return $this;
    }

    /**
     * Get endpointServerConfig
     *
     * @return \EndpointServerConfig
     */
    public function getEndpointServerConfig()
    {
        return $this->endpointServerConfig;
    }

    /**
     * Set externalServer
     *
     * @param \ExternalServer $externalServer
     *
     * @return Endpoint
     */
    public function setExternalServer(\ExternalServer $externalServer = null)
    {
        $this->externalServer = $externalServer;

        return $this;
    }

    /**
     * Get externalServer
     *
     * @return \ExternalServer
     */
    public function getExternalServer()
    {
        return $this->externalServer;
    }

    /**
     * Set physicalConnection
     *
     * @param \PhysicalConnection $physicalConnection
     *
     * @return Endpoint
     */
    public function setPhysicalConnection(\PhysicalConnection $physicalConnection = null)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     * Get physicalConnection
     *
     * @return \PhysicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }
}
