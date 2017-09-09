<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;
use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\EndpointFtgwWindows;
use DbSystel\DataObject\EndpointFtgwSelfService;
use DbSystel\DataObject\Server;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\EndpointCdZos;
use DbSystel\DataObject\EndpointCdWindows;
use DbSystel\DataObject\EndpointCdWindowsShare;
use DbSystel\DataObject\Protocol;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\IncludeParameterSet;
use DbSystel\DataObject\ProtocolSet;
use DbSystel\DataObject\FileParameterSet;
use DbSystel\DataObject\AccessConfigSet;
use DbSystel\DataObject\EndpointFtgwProtocolServer;
use DbSystel\DataObject\EndpointFtgwWindowsShare;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;
use DbSystel\DataObject\EndpointFtgwCdZos;
use DbSystel\DataObject\EndpointFtgwCdTandem;
use DbSystel\DataObject\EndpointFtgwCdAs400;
use DbSystel\DataObject\ProtocolSetForSelfService;
use DbSystel\DataObject\ProtocolSetForProtocolServer;

class EndpointMapper extends AbstractMapper implements EndpointMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = EndpointMapper::class;

    /**
     *
     * @var ExternalServerMapperInterface
     */
    protected $externalServerMapper;

    /**
     *
     * @var CustomerMapperInterface
     */
    protected $customerMapper;

    /**
     *
     * @var IncludeParameterSetMapperInterface
     */
    protected $includeParameterSetMapper;

    /**
     *
     * @var ProtocolSetMapperInterface
     */
    protected $protocolSetMapper;

    /**
     *
     * @var FileParameterSetMapperInterface
     */
    protected $fileParameterSetMapper;

    /**
     *
     * @var AccessConfigSetMapperInterface
     */
    protected $accessConfigSetMapper;

    /**
     *
     * @var ProtocolMapperInterface
     */
    protected $protocolMapper;

    /**
     *
     * @var EndpointClusterConfigMapperInterface
     */
    protected $endpointClusterConfigMapper;

    /**
     *
     * @param EndpointServerConfigMapperInterface $endpointServerConfigMapper
     */
    public function setEndpointServerConfigMapper(EndpointServerConfigMapperInterface $endpointServerConfigMapper)
    {
        $this->endpointServerConfigMapper = $endpointServerConfigMapper;
    }

    /**
     *
     * @param ExternalServerMapperInterface $externalServerMapper
     */
    public function setExternalServerMapper(ExternalServerMapperInterface $externalServerMapper)
    {
        $this->externalServerMapper = $externalServerMapper;
    }

    /**
     *
     * @param CustomerMapperInterface $customerMapper
     */
    public function setCustomerMapper(CustomerMapperInterface $customerMapper)
    {
        $this->customerMapper = $customerMapper;
    }

    /**
     *
     * @param IncludeParameterSetMapperInterface $includeParameterSetMapper
     */
    public function setIncludeParameterSetMapper(IncludeParameterSetMapperInterface $includeParameterSetMapper)
    {
        $this->includeParameterSetMapper = $includeParameterSetMapper;
    }

    /**
     *
     * @param ProtocolSetMapperInterface $protocolSetMapper
     */
    public function setProtocolSetMapper(ProtocolSetMapperInterface $protocolSetMapper)
    {
        $this->protocolSetMapper = $protocolSetMapper;
    }

    /**
     *
     * @param FileParameterSetMapperInterface $fileParameterSetMapper
     */
    public function setFileParameterSetMapper(FileParameterSetMapperInterface $fileParameterSetMapper)
    {
        $this->fileParameterSetMapper = $fileParameterSetMapper;
    }

    /**
     * @param AccessConfigSetMapperInterface $accessConfigSetMapper
     */
    public function setAccessConfigSetMapper(AccessConfigSetMapperInterface $accessConfigSetMapper)
    {
        $this->accessConfigSetMapper = $accessConfigSetMapper;
    }

    /**
     *
     * @param ProtocolMapperInterface $protocolMapper
     */
    public function setProtocolMapper(ProtocolMapperInterface $protocolMapper)
    {
        $this->protocolMapper = $protocolMapper;
    }

    /**
     *
     * @param EndpointClusterConfigMapperInterface $endpointClusterConfigMapper
     */
    public function setEndpointClusterConfigMapper(EndpointClusterConfigMapperInterface $endpointClusterConfigMapper)
    {
        $this->endpointClusterConfigMapper = $endpointClusterConfigMapper;
    }

    /**
     *
     * @param AbstractEndpoint $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractEndpoint $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['id'] = $dataObject->getId();
        $data['role'] = $dataObject->getRole();
        $data['type'] = $dataObject->getType();
        $data['server_place'] = $dataObject->getServerPlace();
        $data['contact_person'] = $dataObject->getContactPerson();
        $data['physical_connection_id'] = $dataObject->getPhysicalConnection()->getId();
        $data['application_technical_short_name'] = $dataObject->getApplication() && $dataObject->getApplication()->getTechnicalShortName() ? $dataObject->getApplication()->getTechnicalShortName() : new Expression(
            'NULL');
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        $newCustomer = $this->customerMapper->save($dataObject->getCustomer());
        $newEndpointServerConfig = $this->endpointServerConfigMapper->save($dataObject->getEndpointServerConfig());
        if(! empty($dataObject->getExternalServer()) && ! empty($dataObject->getExternalServer()->getName())) {
            $newExternalServer = $this->externalServerMapper->save($dataObject->getExternalServer());
            $data['external_server_id'] = $newExternalServer->getId();
        } else {
            $data['external_server_id'] = new Expression('NULL');
        }
        // data from the recently persisted objects
        $data['customer_id'] = $newCustomer->getId();
        $data['endpoint_server_config_id'] = $newEndpointServerConfig->getId();

        $isUpdate = false;
        if (! $data['id']) {
            $action = new Insert('endpoint');
            $action->values($data);
        } else {
            $action = new Update('endpoint');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
            $isUpdate = true;
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            $concreteSaveMethod = 'save' . $data['type'];
            $concreteDataObject = $this->$concreteSaveMethod($dataObject, $isUpdate);
            return $concreteDataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdAs400 $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdAs400
     * @throws \Exception
     */
    protected function saveCdAs400(EndpointCdAs400 $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_as400');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_as400');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdTandem $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdTandem
     * @throws \Exception
     */
    protected function saveCdTandem(EndpointCdTandem $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_tandem');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_tandem');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdLinuxUnix $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdLinuxUnix
     * @throws \Exception
     */
    protected function saveCdLinuxUnix(EndpointCdLinuxUnix $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        $data['transmission_type'] = $dataObject->getTransmissionType();
        $data['transmission_interval'] = $dataObject->getTransmissionInterval();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        $newEndpointClusterConfig = $this->endpointClusterConfigMapper->save($dataObject->getEndpointClusterConfig());
        
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }
        $data['endpoint_cluster_config_id'] = $newEndpointClusterConfig->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_linux_unix');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_linux_unix');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
                // ...
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdWindows $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdWindows
     * @throws \Exception
     */
    protected function saveCdWindows(EndpointCdWindows $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['folder'] = $dataObject->getFolder();
        $data['transmission_type'] = $dataObject->getTransmissionType();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_windows');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_windows');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdWindowsShare $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdWindowsShare
     * @throws \Exception
     */
    protected function saveCdWindowsShare(EndpointCdWindowsShare $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['sharename'] = $dataObject->getSharename();
        $data['folder'] = $dataObject->getFolder();
        $data['transmission_type'] = $dataObject->getTransmissionType();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        $newAccessConfigSet = $this->accessConfigSetMapper->save($dataObject->getAccessConfigSet());
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }
        $data['access_config_set_id'] = $newAccessConfigSet->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_windows_share');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_windows_share');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdZos $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointCdZos
     * @throws \Exception
     */
    protected function saveCdZos(EndpointCdZos $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_TARGET) {
            $newFileParameterSet = $this->fileParameterSetMapper->save($dataObject->getFileParameterSet());
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_TARGET) {
            $data['file_parameter_set_id'] = $newFileParameterSet->getId();
        }

        if (! $isUpdate) {
            $action = new Insert('endpoint_cd_zos');
            $action->values($data);
        } else {
            $action = new Update('endpoint_cd_zos');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwSelfService $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwSelfService
     * @throws \Exception
     */
    protected function saveFtgwSelfService(EndpointFtgwSelfService $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['connection_type'] = $dataObject->getConnectionType();
        $data['ftgw_username'] = $dataObject->getFtgwUsername();
        $data['mailbox'] = $dataObject->getMailbox();
        // creating sub-objects
        $newProtocolSet = $this->protocolSetMapper->save($dataObject->getProtocolSet());
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        $data['protocol_set_id'] = $newProtocolSet->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_self_service');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_self_service');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                $dataObject->setId($newEndpointId);
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
                // ...
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwProtocolServer $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwProtocolServer
     * @throws \Exception
     */
    protected function saveFtgwProtocolServer(EndpointFtgwProtocolServer $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        $data['dns_address'] = $dataObject->getDnsAddress();
        $data['ip'] = $dataObject->getIp();
        $data['port'] = $dataObject->getPort();
        $data['transmission_type'] = $dataObject->getTransmissionType();
        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        $newProtocolSet = $this->protocolSetMapper->save($dataObject->getProtocolSet());
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }
        $data['protocol_set_id'] = $newProtocolSet->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_protocol_server');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_protocol_server');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                $dataObject->setId($newEndpointId);
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
                // ...
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwWindows $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwWindows
     * @throws \Exception
     */
    protected function saveFtgwWindows(EndpointFtgwWindows $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_windows');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_windows');
            $action->where(['id' => $data['id']]);
            // Don't unset the $data['id'], since its the only field to UPDATE!
            // unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwWindowsShare $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwWindowsShare
     * @throws \Exception
     */
    protected function saveFtgwWindowsShare(EndpointFtgwWindowsShare $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['sharename'] = $dataObject->getSharename();
        $data['folder'] = $dataObject->getFolder();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        $newAccessConfigSet = $this->accessConfigSetMapper->save($dataObject->getAccessConfigSet());
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }
        $data['access_config_set_id'] = $newAccessConfigSet->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_windows_share');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_windows_share');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwLinuxUnix $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwLinuxUnix
     * @throws \Exception
     */
    protected function saveFtgwLinuxUnix(EndpointFtgwLinuxUnix $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        $data['transmission_type'] = $dataObject->getTransmissionType();
        $data['transmission_interval'] = $dataObject->getTransmissionInterval();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        $newEndpointClusterConfig = $this->endpointClusterConfigMapper->save($dataObject->getEndpointClusterConfig());
        
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }
        $data['endpoint_cluster_config_id'] = $newEndpointClusterConfig->getId();

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_linux_unix');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_linux_unix');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
                // ...
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwCdZos $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwCdZos
     * @throws \Exception
     */
    protected function saveFtgwCdZos(EndpointFtgwCdZos $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();

        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_TARGET) {
            $newFileParameterSet = $this->fileParameterSetMapper->save($dataObject->getFileParameterSet());
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_TARGET) {
            $data['file_parameter_set_id'] = $newFileParameterSet->getId();
        }

        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_cd_zos');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_cd_zos');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwCdTandem $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwCdTandem
     * @throws \Exception
     */
    protected function saveFtgwCdTandem(EndpointFtgwCdTandem $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
    
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
    
        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_cd_tandem');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_cd_tandem');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }
    
        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwCdAs400 $dataObject
     * @param boolean $isUpdate
     *
     * @return EndpointFtgwCdAs400
     * @throws \Exception
     */
    protected function saveFtgwCdAs400(EndpointFtgwCdAs400 $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
    
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();
    
        if (! $isUpdate) {
            $action = new Insert('endpoint_ftgw_cd_as400');
            $action->values($data);
        } else {
            $action = new Update('endpoint_ftgw_cd_as400');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        }
    
        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
    
        if ($result instanceof ResultInterface) {
            $newEndpointId = $dataObject->getId();
            if ($newEndpointId) {
                // creating sub-objects: in this case only now possible, since the $newEndpointId is needed
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
