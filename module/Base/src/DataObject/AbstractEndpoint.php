<?php
namespace Base\DataObject;

use ReflectionClass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * AbstractEndpoint
 *
 * @ORM\Table(
 *     name="endpoint",
 *     indexes={
 *         @ORM\Index(name="fk_endpoint_physical_connection_idx", columns={"physical_connection_id"}),
 *         @ORM\Index(name="fk_endpoint_application_idx", columns={"application_technical_short_name"}),
 *         @ORM\Index(name="fk_endpoint_customer_idx", columns={"customer_id"}),
 *         @ORM\Index(name="fk_endpoint_endpoint_server_config_idx", columns={"endpoint_server_config_id"}),
 *         @ORM\Index(name="fk_endpoint_external_server_idx", columns={"external_server_id"})
 *     }
 * )
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "CdAs400" = "EndpointCdAs400",
 *     "CdTandem" = "EndpointCdTandem",
 *     "CdLinuxUnix" = "EndpointCdLinuxUnix",
 *     "CdWindows" = "EndpointCdWindows",
 *     "CdWindowsShare" = "EndpointCdWindowsShare",
 *     "CdZos" = "EndpointCdZos",
 *     "FtgwWindows" = "EndpointFtgwWindows",
 *     "FtgwSelfService" = "EndpointFtgwSelfService",
 *     "FtgwProtocolServer" = "EndpointFtgwProtocolServer",
 *     "FtgwWindowsShare" = "EndpointFtgwWindowsShare",
 *     "FtgwLinuxUnix" = "EndpointFtgwLinuxUnix",
 *     "FtgwCdZos" = "EndpointFtgwCdZos",
 *     "FtgwCdTandem" = "EndpointFtgwCdTandem",
 *     "FtgwCdAs400" = "EndpointFtgwCdAs400",
 *     "FtgwAwsS3" = "EndpointFtgwAwsS3"
 * })
 */
abstract class AbstractEndpoint extends AbstractDataObject
{

    /** @var string */
    const TYPE_CD_AS400 = 'CdAs400';
    /** @var string */
    const TYPE_CD_TANDEM = 'CdTandem';
    /** @var string */
    const TYPE_CD_LINUX_UNIX = 'CdLinuxUnix';
    /** @var string */
    const TYPE_CD_WINDOWS = 'CdWindows';
    /** @var string */
    const TYPE_CD_WINDOWS_SHARE = 'CdWindowsShare';
    /** @var string */
    const TYPE_CD_ZOS = 'CdZos';
    /** @var string */
    const TYPE_FTGW_WINDOWS = 'FtgwWindows';
    /** @var string */
    const TYPE_FTGW_SELF_SERVICE = 'FtgwSelfService';
    /** @var string */
    const TYPE_FTGW_PROTOCOL_SERVER = 'FtgwProtocolServer';
    /** @var string */
    const TYPE_FTGW_WINDOWS_SHARE = 'FtgwWindowsShare';
    /** @var string */
    const TYPE_FTGW_LINUX_UNIX = 'FtgwLinuxUnix';
    /** @var string */
    const TYPE_FTGW_CD_ZOS = 'FtgwCdZos';
    /** @var string */
    const TYPE_FTGW_CD_TANDEM = 'FtgwCdTandem';
    /** @var string */
    const TYPE_FTGW_CD_AS400 = 'FtgwCdAs400';
    /** @var string */
    const TYPE_FTGW_AWS_S3 = 'FtgwAwsS3';

    /** @var string */
    const ROLE_SOURCE = 'source';
    /** @var string */
    const ROLE_TARGET = 'target';

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
     * @ORM\Column(name="role", type="string", nullable=true)
     */
    protected $role;

    /**
     * @var string
     *
     * @ORM\Column(name="server_place", type="string", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $serverPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_person", type="string", length=500, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $contactPerson;

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
     * @var Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_technical_short_name", referencedColumnName="technical_short_name")
     * })
     *
     * @Groups({"export"})
     */
    protected $application;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $customer;

    /**
     * @var EndpointServerConfig
     *
     * @ORM\OneToOne(targetEntity="EndpointServerConfig", inversedBy="endpoint", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="endpoint_server_config_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $endpointServerConfig;

    /**
     * @var ExternalServer
     *
     * @ORM\OneToOne(targetEntity="ExternalServer", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="external_server_id", referencedColumnName="id")
     * })
     *
     * @Groups({"export"})
     */
    protected $externalServer;

    /**
     * @var AbstractPhysicalConnection
     *
     * @ORM\ManyToOne(targetEntity="AbstractPhysicalConnection", inversedBy="endpoints")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="physical_connection_id", referencedColumnName="id")
     * })
     */
    protected $physicalConnection;

    /**
     * @param integer $id
     *
     * @return AbstractEndpoint
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
     *
     * @Groups({"export"})
     */
    public function getType()
    {
        return str_replace(
            'Endpoint',
            '',
            (new ReflectionClass($this))->getShortName()
        );
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
    public function setPhysicalConnection(AbstractPhysicalConnection $physicalConnection)
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
