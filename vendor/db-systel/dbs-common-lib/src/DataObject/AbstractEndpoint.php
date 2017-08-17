<?php
namespace DbSystel\DataObject;

/**
 * Class AbstractEndpoint
 *
 * @package DbSystel\DataObject
 */
abstract class AbstractEndpoint extends AbstractDataObject
{

    const TYPE_CD_AS400 = 'CdAs400';

    const TYPE_CD_TANDEM = 'CdTandem';

    const TYPE_CD_LINUX_UNIX = 'CdLinuxUnix';

    const TYPE_CD_WINDOWS = 'CdWindows';

    const TYPE_CD_WINDOWS_SHARE = 'CdWindowsShare';

    const TYPE_CD_ZOS = 'CdZos';

    const TYPE_FTGW_WINDOWS = 'FtgwWindows';

    const TYPE_FTGW_SELF_SERVICE = 'FtgwSelfService';

    const TYPE_FTGW_PROTOCOL_SERVER = 'FtgwProtocolServer';

    const TYPE_FTGW_WINDOWS_SHARE = 'FtgwWindowsShare';

    const TYPE_FTGW_LINUX_UNIX = 'FtgwLinuxUnix';

    const TYPE_FTGW_CD_ZOS = 'FtgwCdZos';

    const TYPE_FTGW_CD_TANDEM = 'FtgwCdTandem';

    const TYPE_FTGW_CD_AS400 = 'FtgwCdAs400';

    const ROLE_SOURCE = 'source';

    const ROLE_TARGET = 'target';

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $role;

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $serverPlace;

    /**
     *
     * @var string
     */
    protected $contactPerson;

    /**
     *
     * @var AbstractPhysicalConnection
     */
    protected $physicalConnection;

    /**
     *
     * @var ExternalServer
     */
    protected $externalServer;

    /**
     *
     * @var Application
     */
    protected $application;

    /**
     *
     * @var Customer
     */
    protected $customer;

    /**
     *
     * @var EndpointServerConfig
     */
    protected $endpointServerConfig;

    /**
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     *
     * @return string $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $serverPlace
     */
    public function setServerPlace($serverPlace)
    {
        $this->serverPlace = $serverPlace;

        return $this;
    }

    /**
     *
     * @return string $serverPlace
     */
    public function getServerPlace()
    {
        return $this->serverPlace;
    }

    /**
     *
     * @param string $contactPerson
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     *
     * @return string $contactPerson
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnection
     */
    public function setPhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;

        return $this;
    }

    /**
     *
     * @return AbstractPhysicalConnection $physicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

    /**
     * @param ExternalServer $externalServer
     */
    public function setExternalServer(ExternalServer $externalServer)
    {
        $this->externalServer = $externalServer;

        return $this;
    }

    /**
     * @return ExternalServer $externalServer
     */
    public function getExternalServer()
    {
        return $this->externalServer;
    }

    /**
     *
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     *
     * @return Application $application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     *
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     *
     * @return Customer $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     *
     * @param EndpointServerConfig $endpointServerConfig
     */
    public function setEndpointServerConfig(EndpointServerConfig $endpointServerConfig)
    {
        $this->endpointServerConfig = $endpointServerConfig;

        return $this;
    }

    /**
     *
     * @return EndpointServerConfig $endpointServerConfig
     */
    public function getEndpointServerConfig()
    {
        return $this->endpointServerConfig;
    }

}
