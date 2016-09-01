<?php
namespace DbSystel\DataObject;

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

    const ROLE_SOURCE = 'source';

    const ROLE_TARGET = 'target';

    /**
     *
     * @var int
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
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     *
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     *
     * @return the $serverPlace
     */
    public function getServerPlace()
    {
        return $this->serverPlace;
    }

    /**
     *
     * @param string $serverPlace
     */
    public function setServerPlace($serverPlace)
    {
        $this->serverPlace = $serverPlace;
    }

    /**
     *
     * @return the $contactPerson
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     *
     * @param string $contactPerson
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     *
     * @return the $physicalConnection
     */
    public function getPhysicalConnection()
    {
        return $this->physicalConnection;
    }

    /**
     *
     * @param AbstractPhysicalConnection $physicalConnection
     */
    public function setPhysicalConnection(AbstractPhysicalConnection $physicalConnection)
    {
        $this->physicalConnection = $physicalConnection;
    }

    /**
     * @return the $externalServer
     */
    public function getExternalServer()
    {
        return $this->externalServer;
    }

    /**
     * @param ExternalServer $externalServer
     */
    public function setExternalServer(ExternalServer $externalServer)
    {
        $this->externalServer = $externalServer;
    }

    /**
     *
     * @return the $application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     *
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    /**
     *
     * @return the $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     *
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     *
     * @return the $endpointServerConfig
     */
    public function getEndpointServerConfig()
    {
        return $this->endpointServerConfig;
    }

    /**
     *
     * @param EndpointServerConfig $endpointServerConfig
     */
    public function setEndpointServerConfig(EndpointServerConfig $endpointServerConfig)
    {
        $this->endpointServerConfig = $endpointServerConfig;
    }

}
