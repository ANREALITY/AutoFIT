<?php
namespace DbSystel\DataObject;

abstract class AbstractEndpoint extends AbstractDataObject
{

    const TYPE_CD_AS400 = 'CdAs400';

    const TYPE_CD_TANDEM = 'CdTandem';

    const TYPE_CD_LINUX_UNIX = 'CdLinuxUnix';

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
     * @var Server
     */
    protected $server;

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
     *
     * @return the $server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     *
     * @param Server $server            
     */
    public function setServer(Server $server)
    {
        $this->server = $server;
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

}
