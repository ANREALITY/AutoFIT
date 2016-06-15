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

class ApplicationMapper extends AbstractMapper implements ApplicationMapperInterface
{

    /**
     *
     * @var Application
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Application $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $technicalShortName
     *
     * @return Application
     * @throws \InvalidArgumentException
     */
    public function findOne($technicalShortName)
    {
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
                            'application.technical_short_name LIKE ?' => '%' . $condition['technical_short_name'] . '%'
                        ]);
                }
                if (array_key_exists('active', $condition)) {
                    $select->where(
                        [
                            'application.active = ?' => $condition['active']
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
