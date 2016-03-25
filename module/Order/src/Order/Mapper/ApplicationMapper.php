<?php
namespace Order\Mapper;

use DbSystel\DataObject\Application;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class ApplicationMapper implements ApplicationMapperInterface
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
     * @var Application
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Application $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $technicalShortName
     *
     * @return Application
     * @throws \InvalidArgumentException
     */
    public function find($technicalShortName)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('application');
         * $select->where([
         * 'technical_short_name = ?' => $technicalShortName
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("Application with given technical short name:{$technicalShortName} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Application[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('application');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('technical_short_name', $condition)) {
                    $select->where(
                        [
                            'technical_short_name LIKE ?' => '%' . $condition['technical_short_name'] . '%'
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
     * @param Application $dataObject
     *
     * @return Application
     * @throws \Exception
     */
    public function save(Application $dataObject)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

}
