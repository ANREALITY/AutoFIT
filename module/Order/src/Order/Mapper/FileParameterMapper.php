<?php
namespace Order\Mapper;

use DbSystel\DataObject\FileParameter;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Expression;

class FileParameterMapper extends AbstractMapper implements FileParameterMapperInterface
{

    /**
     *
     * @var FileParameter
     */
    protected $prototype;

    /**
     *
     * @param int|string $id
     *
     * @return FileParameter
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|FileParameter[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('file_parameter');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['file_parameter_set_id'])) {
                    $select->where(
                        [
                            'file_parameter_set_id = ?' => $condition['file_parameter_set_id']
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
     * @param FileParameter $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return FileParameter
     * @throws \Exception
     */
    public function save(FileParameter $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['filename'] = $dataObject->getFilename() ?: new Expression('NULL');
        $data['record_length'] = $dataObject->getRecordLength() ?: new Expression('NULL');
        $data['blocking'] = $dataObject->getBlocking() ?: new Expression('NULL');
        $data['block_size'] = $dataObject->getBlocking() === FileParameter::BLOCKING_FIXED && $dataObject->getBlockSize()
            ? $dataObject->getBlockSize()
            : new Expression('NULL')
        ;
        $data['file_parameter_set_id'] = $dataObject->getFileParameterSet()->getId();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if ($data['id'] && $updateIfIdSet) {
            $action = new Update('file_parameter');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('file_parameter');
            $action->values($data);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

    public function deleteAll(array $criteria)
    {
        $action = new Delete('file_parameter');

        $return = false;
        $conditionGiven = false;

        if (! empty($criteria)) {
            foreach ($criteria as $condition) {
                if (is_array($condition)) {
                    if (! empty($condition['file_parameter_set_id'])) {
                        $action->where(
                            [
                                'file_parameter_set_id = ?' => $condition['file_parameter_set_id']
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
