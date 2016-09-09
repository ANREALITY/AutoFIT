<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgw;
use DbSystel\DataObject\PhysicalConnectionCd;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use DbSystel\DataObject\LogicalConnection;
use DbSystel\DataObject\AbstractEndpoint;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use DbSystel\DataObject\EndpointCdAs400;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\EndpointCdLinuxUnix;
use DbSystel\DataObject\EndpointFtgwSelfService;
use DbSystel\DataObject\EndpointFtgwWindows;
use DbSystel\DataObject\EndpointCdWindows;
use DbSystel\DataObject\EndpointCdZos;
use DbSystel\DataObject\EndpointCdWindowsShare;
use DbSystel\DataObject\EndpointFtgwProtocolServer;

class PhysicalConnectionMapper extends AbstractMapper implements PhysicalConnectionMapperInterface
{

    /**
     *
     * @var AbstractPhysicalConnection
     */
    protected $prototype;

    /**
     *
     * @var AbstractEndpointMapper
     */
    protected $endpointMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator)
    {
        parent::__construct($dbAdapter, $hydrator);
    }

    /**
     *
     * @param EndpointMapperInterface $endpointMapper
     */
    public function setEndpointMapper(EndpointMapperInterface $endpointMapper)
    {
        $this->endpointMapper = $endpointMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractPhysicalConnectionMapper::find()
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return AbstractPhysicalConnection
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('physical_connection');
        $select->where([
            'physical_connection.id = ?' => $id
        ]);

        $select->join([
            'endpoint_source' => 'endpoint'
        ],
            new Expression(
                'endpoint_source.physical_connection_id = physical_connection.id AND endpoint_source.role = ' . '"' .
                     AbstractEndpoint::ROLE_SOURCE . '"'),
            [
                'endpoint_source_id' => 'id'
            ], Select::JOIN_LEFT);

        $select->join([
            'endpoint_target' => 'endpoint'
        ],
            new Expression(
                'endpoint_target.physical_connection_id = physical_connection.id AND endpoint_target.role = ' . '"' .
                     AbstractEndpoint::ROLE_TARGET . '"'),
            [
                'endpoint_target_id' => 'id'
            ], Select::JOIN_LEFT);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $data = $result->current();
            if (! empty($data['type'])) {
                if (strcasecmp($data['type'], LogicalConnection::TYPE_CD) === 0) {
                    $this->prototype = new PhysicalConnectionCd();
                } elseif (strcasecmp($data['type'], LogicalConnection::TYPE_FTGW) === 0) {
                    $this->prototype = new PhysicalConnectionFtgw();
                }
                $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());

                if (! empty($data['endpoint_source_id'])) {
                    $return->setEndpointSource($this->endpointMapper->findWithBuldledData($data['endpoint_source_id']));
                }
                if (! empty($data['endpoint_target_id'])) {
                    $return->setEndpointTarget($this->endpointMapper->findWithBuldledData($data['endpoint_target_id']));
                }
            } else {
                $return = null;
            }

            return $return;
        }
    }

    /**
     *
     * @return array|AbstractPhysicalConnection[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param AbstractPhysicalConnection $dataObject
     *
     * @return LogicalConnection
     * @throws \Exception
     */
    public function save(AbstractPhysicalConnection $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['role'] = $dataObject->getRole();
        $data['type'] = $dataObject->getType();
        // $data['foo'] = $dataObject->getFoo();
        $data['logical_connection_id'] = $dataObject->getLogicalConnection()->getId();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        // none

        $isUpdate = false;
        if (! $data['id']) {
            $action = new Insert('physical_connection');
            $action->values($data);
        } else {
            $action = new Update('physical_connection');
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
                // creating sub-objects: in this case only now possible, since the $newId is needed
                if ($dataObject->getEndpointSource()) {
                    $dataObject->getEndpointSource()->setPhysicalConnection($dataObject);
                    $newEndpointSource = $this->endpointMapper->save($dataObject->getEndpointSource());
                    $dataObject->setEndpointSource($newEndpointSource);
                }
                if ($dataObject->getEndpointTarget()) {
                    $dataObject->getEndpointTarget()->setPhysicalConnection($dataObject);
                    $newEndpointTarget = $this->endpointMapper->save($dataObject->getEndpointTarget());
                    $dataObject->setEndpointTarget($newEndpointTarget);
                }
            }
            $concreteSaveMethod = 'save' . $data['type'];
            $concreteDataObject = $this->$concreteSaveMethod($dataObject, $isUpdate);
            return $concreteDataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param PhysicalConnectionCd $dataObject
     * @param boolean $isUpdate
     *
     * @return PhysicalConnectionCd
     * @throws \Exception
     */
    public function saveCd(AbstractPhysicalConnection $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        $data['secure_plus'] = $dataObject->getSecurePlus();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['physical_connection_id'] = $dataObject->getId();

        if (! $isUpdate) {
            $action = new Insert('physical_connection_cd');
            $action->values($data);
        } else {
            $action = new Update('physical_connection_cd');
            $action->where(['physical_connection_id' => $data['physical_connection_id']]);
            unset($data['physical_connection_id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * @param PhysicalConnectionFtgw $dataObject
     * @param boolean $isUpdate
     *
     * @return PhysicalConnectionFtgw
     * @throws \Exception
     */
    public function saveFtgw(AbstractPhysicalConnection $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['physical_connection_id'] = $dataObject->getId();

        if (! $isUpdate) {
            $action = new Insert('physical_connection_ftgw');
            $action->values($data);
        } else {
            $action = new Update('physical_connection_ftgw');
            $action->where(['physical_connection_id' => $data['physical_connection_id']]);
            // Don't unset the $data['physical_connection_id'], since its the only field to UPDATE!
            // unset($data['physical_connection_id']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null,
        $identifier = null, $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null,
        callable $dataObjectCondition = null, bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, $parentIdentifier, $parentPrefix, $identifier, $prefix, null, null, $prototype, $dataObjectCondition, $isCollection);

        $endpointCdAs400SourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_as400__'], null, null, new EndpointCdAs400(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_AS400;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdAs400TargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_as400__'], null, null, new EndpointCdAs400(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_AS400;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdTandemSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_tandem__'], null, null, new EndpointCdTandem(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_TANDEM;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdTandemTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_tandem__'], null, null, new EndpointCdTandem(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_TANDEM;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdLinuxUnixSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_linux_unix__'], null, null, new EndpointCdLinuxUnix(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_LINUX_UNIX;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdLinuxUnixTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_linux_unix__'], null, null, new EndpointCdLinuxUnix(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_LINUX_UNIX;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdWindowsSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_windows__'], null, null, new EndpointCdWindows(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_WINDOWS;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdWindowsTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_windows__'], null, null, new EndpointCdWindows(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_WINDOWS;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdZosSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_zos__'], null, null, new EndpointCdZos(),
            function (array $row) {
                $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_ZOS;
                $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                return $typeIsOk && $roleIsOk;
            });
        $endpointCdZosTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_zos__'], null, null, new EndpointCdZos(),
            function (array $row) {
                $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_ZOS;
                $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                return $typeIsOk && $roleIsOk;
            });
        $endpointCdWindowsShareSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_windows_share__'], null, null, new EndpointCdWindowsShare(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_WINDOWS_SHARE;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointCdWindowsShareTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_cd_windows_share__'], null, null, new EndpointCdWindowsShare(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_CD_WINDOWS_SHARE;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointFtgwWindowsSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_windows__'], null, null, new EndpointFtgwWindows(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_WINDOWS;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointFtgwWindowsTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_windows__'], null, null, new EndpointFtgwWindows(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_WINDOWS;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointFtgwSelfServiceSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_self_service__'], null, null, new EndpointFtgwSelfService(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_SELF_SERVICE;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointFtgwSelfServiceTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_self_service__'], null, null, new EndpointFtgwSelfService(),
                function (array $row) {
                    $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_SELF_SERVICE;
                    $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                    return $typeIsOk && $roleIsOk;
                });
        $endpointFtgwProtocolServerSourceDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_protocol_server__'], null, null, new EndpointFtgwProtocolServer(),
            function (array $row) {
                $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_PROTOCOL_SERVER;
                $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_SOURCE;
                return $typeIsOk && $roleIsOk;
            });
        $endpointFtgwProtocolServerTargetDataObjects = $this->endpointMapper->createDataObjects($resultSetArray,
            'id', 'physical_connection__', ['id', 'endpoint_id'], ['endpoint__', 'endpoint_ftgw_protocol_server__'], null, null, new EndpointFtgwProtocolServer(),
            function (array $row) {
                $typeIsOk = array_key_exists('endpoint' . '__' . 'type', $row) && $row['endpoint' . '__' . 'type'] === AbstractEndpoint::TYPE_FTGW_PROTOCOL_SERVER;
                $roleIsOk = array_key_exists('endpoint' . '__' . 'role', $row) && $row['endpoint' . '__' . 'role'] === AbstractEndpoint::ROLE_TARGET;
                return $typeIsOk && $roleIsOk;
            });

        foreach ($dataObjects as $key => $dataObject) {
            // DANGEROUS!!!
            // Array key of a common element (created like myArray[] = new Element();)
            // can though equal to the $dataObject->getId()!!!!!
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdAs400SourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdAs400TargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdTandemSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdTandemTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdLinuxUnixSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdLinuxUnixTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdWindowsSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdWindowsTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdZosSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdZosTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdWindowsShareSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointCdWindowsShareTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwWindowsSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwWindowsTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwSelfServiceSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwSelfServiceTargetDataObjects,
                'setEndpointTarget', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwProtocolServerSourceDataObjects,
                'setEndpointSource', 'getId');
            $this->appendSubDataObject($dataObject, $dataObject->getId(), $endpointFtgwProtocolServerTargetDataObjects,
                'setEndpointTarget', 'getId');
        }

        return $dataObjects;
    }

}
