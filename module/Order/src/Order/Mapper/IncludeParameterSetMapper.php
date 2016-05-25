<?php
namespace Order\Mapper;

use DbSystel\DataObject\IncludeParameterSet;
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
     * @var IncludeParameterSet
     */
    protected $prototype;

    /**
     *
     * @var IncludeParameterMapperInterface
     */
    protected $includeParameterMapper;

    /**
     *
     * @var type
     */
    protected $type;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, IncludeParameterSet $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

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
     * @param int|string $id
     *
     * @return IncludeParameterSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|IncludeParameterSet[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return IncludeParameterSet
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('include_parameter_set');
        $select->where([
            'include_parameter_set.id = ?' => $id
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());
            $data = $result->current();

            return $return;
        }

        throw new \InvalidArgumentException("IncludeParameterSet with given ID:{$id} not found.");
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

        $sql = 'INSERT INTO include_parameter_set VALUES ();';
        $result = $this->dbAdapter->getDriver()
            ->getConnection()
            ->execute($sql);

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
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
                foreach ($dataObject->getIncludeParameters() as $includeParameter) {
                    if ($includeParameter->getExpression()) {
                        $includeParameter->setIncludeParameterSet($dataObject);
                        $newIncludeParameters[] = $this->includeParameterMapper->save($includeParameter);
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

    public function createDataObjects(array $resultSetArray, $parentIdentifier = null, $parentPrefix = null, $identifier = null,
        $prefix = null, $childIdentifier = null, $childPrefix = null, $prototype = null, callable $dataObjectCondition = null,
        bool $isCollection = false)
    {
        $dataObjects = parent::createDataObjects($resultSetArray, null, null, $identifier, $prefix, $childIdentifier,
            $childPrefix, $prototype, $dataObjectCondition, $isCollection);

        // @todo It's a hack! Find a clean solution!
        if ($prefix === 'endpoint_cd_linux_unix_include_parameter_set__') {
            $cdLinuxUnixIncludeParameterDataObjects = $this->includeParameterMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_cd_linux_unix_include_parameter__', null, null, null, null, true);
        }
        if ($prefix === 'endpoint_ftgw_windows_include_parameter_set__') {
            $ftgwWindowsIncludeParameterDataObjects = $this->includeParameterMapper->createDataObjects($resultSetArray,
                $identifier, $prefix, 'id', 'endpoint_ftgw_windows_include_parameter__', null, null, null, null, true);
        }

        foreach ($dataObjects as $key => $dataObject) {
            // DANGEROUS!!!
            // Array key of a common element (created like myArray[] = new Element();)
            // can though quals to the $dataObject->getId()!!!!!
            if ($prefix === 'endpoint_cd_linux_unix_include_parameter_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $cdLinuxUnixIncludeParameterDataObjects,
                    'setIncludeParameters', 'getId');
            }
            if ($prefix === 'endpoint_ftgw_windows_include_parameter_set__') {
                $this->appendSubDataObject($dataObject, $dataObject->getId(), $ftgwWindowsIncludeParameterDataObjects,
                    'setIncludeParameters', 'getId');
            }
        }

        return $dataObjects;
    }

}
