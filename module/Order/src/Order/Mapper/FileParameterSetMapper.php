<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameterSet;
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

class FileParameterSetMapper extends AbstractMapper implements FileParameterSetMapperInterface
{

    /**
     *
     * @var FileParameterSet
     */
    protected $prototype;

    /**
     *
     * @var FileParameterMapperInterface
     */
    protected $fileParameterMapper;

    /**
     *
     * @var type
     */
    protected $type;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, FileParameterSet $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param FileParameterMapperInterface $fileParameterMapper
     */
    public function setFileParameterMapper(FileParameterMapperInterface $fileParameterMapper)
    {
        $this->fileParameterMapper = $fileParameterMapper;
    }

    /**
     *
     * @param int|string $id
     *
     * @return FileParameterSet
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|FileParameterSet[]
     */
    public function findAll(array $criteria = [])
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return FileParameterSet
     */
    public function findWithBuldledData($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_parameter_set');
        $select->where([
            'file_parameter_set.id = ?' => $id
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $return = $this->hydrator->hydrate($result->current(), $this->getPrototype());
            $data = $result->current();

            return $return;
        }

        throw new \InvalidArgumentException("FileParameterSet with given ID:{$id} not found.");
    }

    /**
     *
     * @param FileParameterSet $dataObject
     *
     * @return FileParameterSet
     * @throws \Exception
     */
    public function save(FileParameterSet $dataObject)
    {
        $data = [];
        // data retrieved directly from the input
        // creating sub-objects
        // data from the recently persisted objects

        if (! $dataObject->getId()) {
            $sql = 'INSERT INTO file_parameter_set VALUES ();';
        } else {
            $sql = 'UPDATE file_parameter_set SET id = ' . $dataObject->getId() . ' WHERE id = ' . $dataObject->getId() .';';
        }
        $result = $this->dbAdapter->getDriver()
            ->getConnection()
            ->execute($sql);

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
                // creating sub-objects: in this case only now possible, since the $newId is needed
                $this->fileParameterMapper->deleteAll(
                    [
                        [
                            'file_parameter_set_id' => $dataObject->getId()
                        ]
                    ]);
                $newFileParameters = [];
                foreach ($dataObject->getFileParameters() ?: [] as $fileParameter) {
                    if ($fileParameter->getFilename()) {
                        $fileParameter->setFileParameterSet($dataObject);
                        $newFileParameters[] = $this->fileParameterMapper->save($fileParameter, false);
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
     * @see FileParameterSetMapperInterface#delete()
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->fileParameterMapper->deleteAll(
            [
                [
                    'file_parameter_set_id' => $id
                ]
            ]);

        $action = new Delete('file_parameter_set');
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

        // @todo

        return $dataObjects;
    }

}
