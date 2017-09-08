<?php
namespace Order\Mapper;

use DbSystel\DataObject\ExternalServer;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
use Zend\Hydrator\HydratorInterface;

class ExternalServerMapper extends AbstractMapper implements ExternalServerMapperInterface
{

    /**
     *
     * @var ExternalServer
     */
    protected $prototype;

    /**
     *
     * @return array|ExternalServer[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('external_server');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('id', $condition)) {
                    $select->where(
                        [
                            'id = ?' => $condition['id']
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
     * @param ExternalServer $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return ExternalServer
     * @throws \Exception
     */
    public function save(ExternalServer $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId() ?: null;
        $data['name'] = $dataObject->getName() ?: null;
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if ($data['id'] && $updateIfIdSet) {
            $action = new Update('external_server');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('external_server');
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

    /**
     * 
     * {@inheritDoc}
     * @see ExternalServerMapperInterface::deleteOneByEndpointId()
     */
    public function deleteOneByEndpointId(int $endpointId)
    {
        $action = new Delete('external_server');

        $return = false;

        $sql = <<<SQL
DELETE `external_server` FROM `external_server`
INNER JOIN `endpoint` ON `endpoint`.`external_server_id` = `external_server`.`id`
WHERE `endpoint`.`id` = {$endpointId}
SQL;

        $result = $this->dbAdapter->getDriver()->getConnection()->execute($sql);
        $return = (bool) $result->getAffectedRows();

        return $return;
    }

}
