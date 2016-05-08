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
use Zend\Db\Sql\Select;

class EnvironmentMapper extends AbstractMapper implements EnvironmentMapperInterface
{

    /**
     *
     * @var Environment
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Environment $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $severity
     *
     * @return Environment
     * @throws \InvalidArgumentException
     */
    public function findOne($severity)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('environment');
         * $select->where([
         * 'severity = ?' => $severity
         * ]);
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
        $select->quantifier(Select::QUANTIFIER_DISTINCT);

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['name'])) {
                    $select->where(
                        [
                            'name LIKE ?' => '%' . $condition['name'] . '%'
                        ]);
                }
                if (! empty($condition['application_technical_short_name'])) {
                    $select->join('service_invoice', 'service_invoice.environment_severity = environment.severity', []);
                    $select->join('application',
                        'application.technical_short_name = service_invoice.application_technical_short_name', []);
                    $select->where(
                        [
                            'application.technical_short_name = ?' => $condition['application_technical_short_name']
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
