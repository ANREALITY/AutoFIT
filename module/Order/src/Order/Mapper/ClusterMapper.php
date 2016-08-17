<?php
namespace Order\Mapper;

use DbSystel\DataObject\Cluster;
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

class ClusterMapper extends AbstractMapper implements ClusterMapperInterface
{

    /**
     *
     * @var Cluster
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Cluster $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $id
     *
     * @return Cluster
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Cluster[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('cluster');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('id', $condition)) {
                    $select->where(
                        [
                            'id = ?' => $condition['id']
                        ]);
                }
                if (array_key_exists('virtual_node_name', $condition)) {
                    $select->where(
                        [
                            'cluster.virtual_node_name LIKE ?' => '%' . $condition['virtual_node_name'] . '%'
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
     * @param Cluster $dataObject
     *
     * @return Cluster
     * @throws \Exception
     */
    public function save(Cluster $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
