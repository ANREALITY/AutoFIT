<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameter;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Delete;

class IncludeParameterMapper extends AbstractMapper implements IncludeParameterMapperInterface
{

    /**
     *
     * @var IncludeParameter
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, IncludeParameter $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $id
     *
     * @return IncludeParameter
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|IncludeParameter[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('include_parameter');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['include_parameter_set_id'])) {
                    $select->where(
                        [
                            'include_parameter_set_id = ?' => $condition['include_parameter_set_id']
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

        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param IncludeParameter $dataObject
     *
     * @return IncludeParameter
     * @throws \Exception
     */
    public function save(IncludeParameter $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        $data['expression'] = $dataObject->getExpression();
        $data['include_parameter_set_id'] = $dataObject->getIncludeParameterSet()->getId();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        $action = new Insert('include_parameter');
        $action->values($data);

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function deleteAll(array $criteria)
    {
        $action = new Delete('include_parameter');

        $return = false;
        $conditionGiven = false;

        if (! empty($criteria)) {
            foreach ($criteria as $condition) {
                if (is_array($condition)) {
                    if (! empty($condition['include_parameter_set_id'])) {
                        $action->where(
                            [
                                'include_parameter_set_id = ?' => $condition['include_parameter_set_id']
                            ]);
                        $conditionGiven = true;
                    }
                }
            }
        }
        if ($conditionGiven) {
            $sql = new Sql($this->dbAdapter);
            $statement = $sql->prepareStatementForSqlObject($action);
            $result = $statement->execute();
            $return = (bool) $result->getAffectedRows();
        }

        return $return;
    }

}
