<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractEndpoint;
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
use DbSystel\DataObject\Cluster;

class EndpointMapper implements EndpointMapperInterface
{

    /**
     *
     * @var AdapterInterface
     */
    protected $dbAdapter;

    /**
     *
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     *
     * @var AbstractEndpoint
     */
    protected $prototype;

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    /**
     *
     * @var ApplicationMapperInterface
     */
    protected $applicationMapper;

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
     * @var ClusterMapperInterface
     */
    protected $clusterMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
    }

    /**
     *
     * @param ServerMapperInterface $serverMapper
     */
    public function setServerMapper(ServerMapperInterface $serverMapper)
    {
        $this->serverMapper = $serverMapper;
    }

    /**
     *
     * @param ApplicationMapperInterface $applicationMapper
     */
    public function setApplicationMapper(ApplicationMapperInterface $applicationMapper)
    {
        $this->applicationMapper = $applicationMapper;
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
     * @param ClusterMapperInterface $clusterMapper
     */
    public function setClusterMapper(ClusterMapperInterface $clusterMapper)
    {
        $this->clusterMapper = $clusterMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractEndpointMapper::find()
     */
    public function find($id)
    {
        // $this->prototype = new Endpoint{CONCRETE_TYPE}();

        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
         * $select->where([
         * 'id = ?' => $id
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("LogicalConnection with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return AbstractEndpoint
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint');
        $select->where([
            'endpoint.id = ?' => $id
        ]);

        $select->join('server', 'server.name = endpoint.server_name', [
            'server_name' => 'name'
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $data = $result->current();
            if (! empty($data['type'])) {
                if (strcasecmp($data['type'], AbstractEndpoint::TYPE_CD_AS400) === 0) {
                    $this->prototype = new EndpointCdAs400();
                } elseif (strcasecmp($data['type'], AbstractEndpoint::TYPE_CD_TANDEM) === 0) {
                    $this->prototype = new EndpointCdTandem();
                } elseif (strcasecmp($data['type'], AbstractEndpoint::TYPE_CD_LINUX_UNIX) === 0) {
                    $this->prototype = new EndpointCdLinuxUnix();
                } elseif (strcasecmp($data['type'], AbstractEndpoint::TYPE_FTGW_SELF_SERVICE) === 0) {
                    $this->prototype = new EndpointFtgwSelfService();
                } elseif (strcasecmp($data['type'], AbstractEndpoint::TYPE_FTGW_WINDOWS) === 0) {
                    $this->prototype = new EndpointFtgwWindows();
                }
                $return = $this->hydrator->hydrate($result->current(), $this->prototype);

                $return->setServer(new Server());
                $return->getServer()->setName($data['server_name']);
            } else {
                $return = null;
            }

            return $return;
        }
    }

    /**
     *
     * @return array|AbstractEndpoint[]
     */
    public function findAll(array $criteria = [])
    {
        // $this->prototype = new Endpoint{CONCRETE_TYPE}();

        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('logical_connection');
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
         *
         * return $resultSet->initialize($result);
         * }
         *
         * return [];
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
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
        $data['role'] = $dataObject->getRole();
        $data['type'] = $dataObject->getType();
        $data['server_place'] = $dataObject->getServerPlace();
        $data['contact_person'] = $dataObject->getContactPerson();
        $data['physical_connection_id'] = $dataObject->getPhysicalConnection()->getId();
        $data['server_name'] = $dataObject->getServer()->getName() ?: new Expression('NULL');
        $data['application_technical_short_name'] = $dataObject->getApplication()->getTechnicalShortName() ?: new Expression(
            'NULL');
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        $newCustomer = $this->customerMapper->save($dataObject->getCustomer());
        // data from the recently persisted objects
        $data['customer_id'] = $newCustomer->getId();

        $action = new Insert('endpoint');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            $concreteSaveMethod = 'save' . $data['type'];
            $concreteDataObject = $this->$concreteSaveMethod($dataObject);
            return $concreteDataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdAs400 $dataObject
     *
     * @return EndpointCdAs400
     * @throws \Exception
     */
    protected function saveCdAs400(EndpointCdAs400 $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['endpoint_id'] = $dataObject->getId();

        $action = new Insert('endpoint_cd_as400');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdTandem $dataObject
     *
     * @return EndpointCdTandem
     * @throws \Exception
     */
    protected function saveCdTandem(EndpointCdTandem $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['username'] = $dataObject->getUsername();
        $data['folder'] = $dataObject->getFolder();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['endpoint_id'] = $dataObject->getId();

        $action = new Insert('endpoint_cd_tandem');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointCdLinuxUnix $dataObject
     *
     * @return EndpointCdLinuxUnix
     * @throws \Exception
     */
    protected function saveCdLinuxUnix(EndpointCdLinuxUnix $dataObject)
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
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_TARGET) {
            if ($dataObject->getCluster() instanceof Cluster && !empty($dataObject->getCluster()->getAddress())) {
                $newCluster = $this->clusterMapper->save($dataObject->getCluster());
                $data['cluster_id'] = $newCluster->getId();
            }
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['endpoint_id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }

        $action = new Insert('endpoint_cd_linux_unix');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwSelfService $dataObject
     *
     * @return EndpointFtgwSelfService
     * @throws \Exception
     */
    protected function saveFtgwSelfService(EndpointFtgwSelfService $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['protocol'] = $dataObject->getProtocol();
        $data['ftgw_username'] = $dataObject->getFtgwUsername();
        $data['mailbox'] = $dataObject->getMailbox();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['endpoint_id'] = $dataObject->getId();

        $action = new Insert('endpoint_ftgw_self_service');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param EndpointFtgwWindows $dataObject
     *
     * @return EndpointFtgwWindows
     * @throws \Exception
     */
    protected function saveFtgwWindows(EndpointFtgwWindows $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        // creating sub-objects
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $newIncludeParameterSet = $this->includeParameterSetMapper->save($dataObject->getIncludeParameterSet());
        }
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['endpoint_id'] = $dataObject->getId();
        if ($dataObject->getRole() === AbstractEndpoint::ROLE_SOURCE) {
            $data['include_parameter_set_id'] = $newIncludeParameterSet->getId();
        }

        $action = new Insert('endpoint_ftgw_windows');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
