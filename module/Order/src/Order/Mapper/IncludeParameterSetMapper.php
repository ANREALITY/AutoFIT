<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameterSet;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Delete;

class IncludeParameterSetMapper extends AbstractMapper implements IncludeParameterSetMapperInterface
{

    /**
     *
     * @var IncludeParameterMapperInterface
     */
    protected $includeParameterMapper;

    /**
     *
     * @param IncludeParameterMapperInterface $includeParameterMapper
     */
    public function setIncludeParameterMapper(IncludeParameterMapperInterface $includeParameterMapper)
    {
        $this->includeParameterMapper = $includeParameterMapper;
    }

    /**
     *
     * @param IncludeParameterSet $dataObject
     *
     * @return IncludeParameterSet
     * @throws \Exception
     */
    public function save(IncludeParameterSet $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // creating sub-objects
        // data from the recently persisted objects

        if (! $dataObject->getId()) {
            $sql = 'INSERT INTO include_parameter_set VALUES ();';
        } else {
            $sql = 'UPDATE include_parameter_set SET id = ' . $dataObject->getId() . ' WHERE id = ' . $dataObject->getId() .';';
        }
        $result = $this->dbAdapter->getDriver()
            ->getConnection()
            ->execute($sql);

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $this->includeParameterMapper->deleteAll(
                    [
                        [
                            'include_parameter_set_id' => $dataObject->getId()
                        ]
                    ]);
                $newIncludeParameters = [];
                foreach ($dataObject->getIncludeParameters() ?: [] as $includeParameter) {
                    if ($includeParameter->getExpression()) {
                        $includeParameter->setIncludeParameterSet($dataObject);
                        $newIncludeParameters[] = $this->includeParameterMapper->save($includeParameter, false);
                    }
                }
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see IncludeParameterSetMapperInterface#delete()
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->includeParameterMapper->deleteAll(
            [
                [
                    'include_parameter_set_id' => $id
                ]
            ]);

        $action = new Delete('include_parameter_set');
        $action->where([
            'id = ?' => $id
        ]);
        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        $return = (bool) $result->getAffectedRows();

        return $return;
    }

}
