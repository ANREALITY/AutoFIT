<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractEndpoint
 *
 * @ORM\Table(name="endpoint", indexes={@ORM\Index(name="fk_endpoint_physical_connection_idx", columns={"physical_connection_id"}), @ORM\Index(name="fk_endpoint_application_idx", columns={"application_technical_short_name"}), @ORM\Index(name="fk_endpoint_customer_idx", columns={"customer_id"}), @ORM\Index(name="fk_endpoint_endpoint_server_config_idx", columns={"endpoint_server_config_id"}), @ORM\Index(name="fk_endpoint_external_server_idx", columns={"external_server_id"})})
 * @ORM\Entity
 */
abstract class AbstractEndpoint extends AbstractDataObject
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
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_technical_short_name", referencedColumnName="technical_short_name")
     * })
     */
    private $application;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @var EndpointServerConfig
     *
     * @ORM\ManyToOne(targetEntity="EndpointServerConfig")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_server_config_id", referencedColumnName="id")
     * })
     */
    private $endpointServerConfig;

    /**
     * @var ExternalServer
     *
     * @ORM\ManyToOne(targetEntity="ExternalServer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="external_server_id", referencedColumnName="id")
     * })
     */
    private $externalServer;

    /**
     * @var AbstractPhysicalConnection
     *
     * @ORM\ManyToOne(targetEntity="AbstractPhysicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="physical_connection_id", referencedColumnName="id")
     * })
     */
    private $physicalConnection;



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
     * @return AbstractEndpoint
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
        return $this->role;
    }

    /**
     * @param string $type
     *
     * @return AbstractEndpoint
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
     * @param string $serverPlace
     *
     * @return AbstractEndpoint
     */
    public function setServerPlace($serverPlace)
    {
        $this->serverPlace = $serverPlace;

        return $this;
    }

    /**
     * @return string
     */
    public function getServerPlace()
    {
        return $this->serverPlace;
    }

    /**
     * @param string $contactPerson
     *
     * @return AbstractEndpoint
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param \DateTime $created
     *
     * @return AbstractEndpoint
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $updated
     *
     * @return AbstractEndpoint
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param Application $application
     *
     * @return AbstractEndpoint
     */
    public function setApplication(Application $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param Customer $customer
     *
     * @return AbstractEndpoint
     */
    public function setCustomer(Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param EndpointServerConfig $endpointServerConfig
     *
     * @return AbstractEndpoint
     */
    public function setEndpointServerConfig(EndpointServerConfig $endpointServerConfig = null)
    {
        $this->endpointServerConfig = $endpointServerConfig;

        return $this;
    }

    /**
     * @return EndpointServerConfig
     */
    public function getEndpointServerConfig()
    {
        return $this->endpointServerConfig;
    }

    /**
     * @param ExternalServer $externalServer
     *
     * @return AbstractEndpoint
     */
    public function setExternalServer(ExternalServer $externalServer = null)
    {
        $this->externalServer = $externalServer;

        return $this;
    }

    /**
     * @return ExternalServer
     */
    public function getExternalServer()
    {
        return $this->externalServer;
    }

    /**
     * @param AbstractPhysicalConnection $physicalConnection
     *
     * @return AbstractEndpoint
     */
    public function setPhysicalConnection(AbstractPhysicalConnection $physicalConnection = null)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     * @return AbstractPhysicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

}
