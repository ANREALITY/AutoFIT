<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointServerConfig;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;

class EndpointServerConfigMapper extends AbstractMapper implements EndpointServerConfigMapperInterface
{

    /**
     *
     * @var EndpointServerConfig
     */
    protected $prototype;

    /**
     *
     * @var ServerMapperInterface
     */
    protected $serverMapper;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, EndpointServerConfig $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
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
     * @param int|string $id
     *
     * @return EndpointServerConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|EndpointServerConfig[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('endpoint_server_config');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('id', $condition)) {
                    $select->where(
                        [
                            'id = ?' => $condition['id']
                        ]);
                }
                if (array_key_exists('dns_address', $condition)) {
                    $select->where(
                        [
                            'endpoint_server_config.dns_address LIKE ?' => '%' . $condition['dns_address'] . '%'
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->getPrototype());

            return $resultSet->initialize($result);
        }

        return [];
    }

    /**
     *
     * @param EndpointServerConfig $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return EndpointServerConfig
     * @throws \Exception
     */
    public function save(EndpointServerConfig $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['dns_address'] = $dataObject->getDnsAddress() ?: new Expression('NULL');
        $data['server_name'] = $dataObject->getServer() && $dataObject->getServer()->getName() ? $dataObject->getServer()->getName() : new Expression('NULL');
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if (! empty($data['id']) && $updateIfIdSet) {
            $action = new Update('endpoint_server_config');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('endpoint_server_config');
            $action->values($data);
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
