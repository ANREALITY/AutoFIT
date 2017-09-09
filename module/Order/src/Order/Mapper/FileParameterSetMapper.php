<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameterSet;
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

class FileParameterSetMapper extends AbstractMapper implements FileParameterSetMapperInterface
{

    /**
     *
     * @var FileParameterMapperInterface
     */
    protected $fileParameterMapper;

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

}
