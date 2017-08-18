<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbstractEndpoint
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
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $serverPlace;

    /**
     * @var string
     */
    private $contactPerson;

    /**
     * @var AbstractPhysicalConnection
     */
    private $physicalConnection;

    /**
     * @var ExternalServer
     */
    private $externalServer;

    /**
     * @var Application
     */
    private $application;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var EndpointServerConfig
     */
    private $endpointServerConfig;

    /**
     * @param integer $id
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
     * @param AbstractPhysicalConnection $physicalConnection
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

    /**
     * @param ExternalServer $externalServer
     * @return AbstractEndpoint
     */
    public function setExternalServer(ExternalServer $externalServer)
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
     * @param Application $application
     * @return AbstractEndpoint
     */
    public function setApplication(Application $application)
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
     * @return AbstractEndpoint
     */
    public function setCustomer(Customer $customer)
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
     * @return AbstractEndpoint
     */
    public function setEndpointServerConfig(EndpointServerConfig $endpointServerConfig)
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

}
