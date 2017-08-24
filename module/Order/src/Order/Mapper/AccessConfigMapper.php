<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfig;
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

class AccessConfigMapper extends AbstractMapper implements AccessConfigMapperInterface
{

    /**
     *
     * @var AccessConfig
     */
    protected $prototype;

    /**
     *
     * @param int|string $id
     *
     * @return AccessConfig
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|AccessConfig[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('access_config');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['access_config_set_id'])) {
                    $select->where(
                        [
                            'access_config_set_id = ?' => $condition['access_config_set_id']
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
     * @param AccessConfig $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return AccessConfig
     * @throws \Exception
     */
    public function save(AccessConfig $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['username'] = $dataObject->getUsername();
        $data['permission_read'] = $dataObject->getPermissionRead();
        $data['permission_write'] = $dataObject->getPermissionWrite();
        $data['permission_delete'] = $dataObject->getPermissionDelete();
        $data['access_config_set_id'] = $dataObject->getAccessConfigSet()->getId();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if ($data['id'] && $updateIfIdSet) {
            $action = new Update('access_config');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('access_config');
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
        $action = new Delete('access_config');

        $return = false;
        $conditionGiven = false;

        if (! empty($criteria)) {
            foreach ($criteria as $condition) {
                if (is_array($condition)) {
                    if (! empty($condition['access_config_set_id'])) {
                        $action->where(
                            [
                                'access_config_set_id = ?' => $condition['access_config_set_id']
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
