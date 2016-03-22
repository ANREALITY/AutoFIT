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

class ServerMapper implements ServerMapperInterface
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
     * @var Server
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Server $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $name            
     *
     * @return Server
     * @throws \InvalidArgumentException
     */
    public function find($name)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('server');
         * $select->where(array(
         * 'technical_short_name = ?' => $name
         * ));
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("Server with given name:{$name} not found.");
         */
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
     * @param Server $dataObject            
     *
     * @return Server
     * @throws \Exception
     */
    public function save(Server $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }
}
