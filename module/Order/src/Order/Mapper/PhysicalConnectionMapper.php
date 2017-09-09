<?php
namespace Order\Mapper;

use DbSystel\DataObject\AbstractPhysicalConnection;
use DbSystel\DataObject\PhysicalConnectionFtgwEndToMiddle;
use DbSystel\DataObject\PhysicalConnectionCdEndToEnd;
use Doctrine\ORM\EntityManager;
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
use DbSystel\DataObject\EndpointFtgwWindowsShare;
use DbSystel\DataObject\EndpointFtgwLinuxUnix;
use DbSystel\DataObject\EndpointFtgwCdZos;
use DbSystel\DataObject\EndpointFtgwCdTandem;
use DbSystel\DataObject\EndpointFtgwCdAs400;

class PhysicalConnectionMapper extends AbstractMapper implements PhysicalConnectionMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = PhysicalConnectionMapper::class;

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
        $data['secure_plus'] = $dataObject->getSecurePlus();
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
     * @param PhysicalConnectionCdEndToEnd $dataObject
     * @param boolean $isUpdate
     *
     * @return PhysicalConnectionCdEndToEnd
     * @throws \Exception
     */
    public function saveCd(AbstractPhysicalConnection $dataObject, bool $isUpdate)
    {
        $data = [];
        // data retrieved directly from the input
        // $data['foo'] = $dataObject->getFoo();
        // creating sub-objects
        // $newBar = $this->barMapper->save($dataObject->getBar());
        // data from the recently persisted objects
        $data['id'] = $dataObject->getId();

        $table = 'physical_connection_cd_end_to_end';

        if (! $isUpdate) {
            $action = new Insert($table);
            $action->values($data);
        } else {
            $action = new Update($table);
            $action->where(['id' => $data['id']]);
            // Don't unset the $data['id'], since its the only field to UPDATE!
            // unset($data['id']);
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
     * @param PhysicalConnectionFtgwEndToMiddle $dataObject
     * @param boolean $isUpdate
     *
     * @return PhysicalConnectionFtgwEndToMiddle
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
        $data['id'] = $dataObject->getId();

        if ($dataObject->getRole() == AbstractPhysicalConnection::ROLE_END_TO_MIDDLE) {
            $table = 'physical_connection_ftgw_end_to_middle';
        } elseif ($dataObject->getRole() == AbstractPhysicalConnection::ROLE_MIDDLE_TO_END) {
            $table = 'physical_connection_ftgw_middle_to_end';
        }

        if (! $isUpdate) {
            $action = new Insert($table);
            $action->values($data);
        } else {
            $action = new Update($table);
            $action->where(['id' => $data['id']]);
            // Don't unset the $data['id'], since its the only field to UPDATE!
            // unset($data['id']);
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

}
