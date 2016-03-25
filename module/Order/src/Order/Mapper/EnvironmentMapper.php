<?php
namespace Order\Mapper;

use DbSystel\DataObject\Environment;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class EnvironmentMapper implements EnvironmentMapperInterface
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
     * @var Environment
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Environment $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $severity
     *
     * @return Environment
     * @throws \InvalidArgumentException
     */
    public function find($severity)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('environment');
         * $select->where(array(
         * 'severity = ?' => $severity
         * ));
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("Environment with given severity:{$severity} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Environment[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('environment');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('name', $condition)) {
                    $select->where(
                        [
                            'name LIKE ?' => '%' . $condition['name'] . '%'
                        ]);
                }
            }
        }

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);

            return $resultSet->initialize($result);
        }

        return [];
    }

    /**
     *
     * @param Environment $dataObject
     *
     * @return Environment
     * @throws \Exception
     */
    public function save(Environment $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
