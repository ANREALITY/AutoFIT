<?php
namespace Order\Mapper;

use DbSystel\DataObject\Server;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class ServerMapper extends AbstractMapper implements ServerMapperInterface
{

    /**
     *
     * @var Server
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Server $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $name
     *
     * @return Server
     * @throws \InvalidArgumentException
     */
    public function findOne($name)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Server[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('server');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('name', $condition)) {
                    $select->where(
                        [
                            'server.name LIKE ?' => '%' . $condition['name'] . '%'
                        ]);
                }
                if (array_key_exists('active', $condition)) {
                    $select->where(
                        [
                            'server.active = ?' => $condition['active']
                        ]);
                }
                if (array_key_exists('node_name', $condition)) {
                    if ($condition['node_name'] === null) {
                        $select->where(
                            [
                                'server.node_name IS ?' => new Expression('NULL')
                            ]);
                    }
                }
                if (array_key_exists('virtual_node_name', $condition)) {
                    if ($condition['virtual_node_name'] === null) {
                        $select->where(
                            [
                                'server.virtual_node_name IS ?' => new Expression('NULL')
                            ]);
                    }
                }
                if (array_key_exists('endpoint_type_name', $condition) && ! empty($condition['endpoint_type_name'])) {
                    $select->join('endpoint_type_server_type', 'endpoint_type_server_type.server_type_id = server.server_type_id', [],
                        Select::JOIN_INNER);
                    $select->join('endpoint_type', 'endpoint_type.id = endpoint_type_server_type.endpoint_type_id', [
                        'endpoint_type_name' => 'name'
                    ], Select::JOIN_INNER);
                    $select->where->expression(
                        'LOWER(endpoint_type.name) = LOWER(?)', $condition['endpoint_type_name']
                    );
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
     * @param Server $dataObject
     *
     * @return Server
     * @throws \Exception
     */
    public function save(Server $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['name'] = $dataObject->getName();
        $data['virtual_node_name'] = $dataObject->getVirtualNodeName();
        // creating sub-objects
        // data from the recently persisted objects

        if (! $data['name']) {
            // No INSERT functionality!
            // $action = new Insert('server');
            // $action->values($data);
        } else {
            $action = new Update('server');
            $action->where(['name' => $data['name']]);
            unset($data['name']);
            $action->set($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newName = $result->getGeneratedValue() ?: $dataObject->getName();
            if ($newName) {
                $dataObject->setName($newName);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
