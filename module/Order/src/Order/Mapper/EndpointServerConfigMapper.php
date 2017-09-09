<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointServerConfig;
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
use Zend\Db\Sql\Expression;

class EndpointServerConfigMapper extends AbstractMapper implements EndpointServerConfigMapperInterface
{

    /**
     *
     * @param EndpointServerConfig $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return EndpointServerConfig
     * @throws \Exception
     */
    public function save(EndpointServerConfig $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['dns_address'] = $dataObject->getDnsAddress() ?: new Expression('NULL');
        $data['server_name'] = $dataObject->getServer() && $dataObject->getServer()->getName() ? $dataObject->getServer()->getName() : new Expression('NULL');
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if (! empty($data['id']) && $updateIfIdSet) {
            $action = new Update('endpoint_server_config');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('endpoint_server_config');
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

}
