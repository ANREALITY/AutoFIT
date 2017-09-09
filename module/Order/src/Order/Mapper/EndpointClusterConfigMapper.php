<?php
namespace Order\Mapper;

use DbSystel\DataObject\EndpointClusterConfig;
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

class EndpointClusterConfigMapper extends AbstractMapper implements EndpointClusterConfigMapperInterface
{

    /**
     *
     * @param EndpointClusterConfig $dataObject
     * @param boolean $updateIfIdSet
     *
     * @return EndpointClusterConfig
     * @throws \Exception
     */
    public function save(EndpointClusterConfig $dataObject, bool $updateIfIdSet = true)
    {
        $data = [];
        // data retrieved directly from the input
        $data['dns_address'] = $dataObject->getDnsAddress() ?: new Expression('NULL');
        $data['cluster_id'] = $dataObject->getCluster() && $dataObject->getCluster()->getId() ? $dataObject->getCluster()->getId() : new Expression('NULL');
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if (! empty($data['id']) && $updateIfIdSet) {
            $action = new Update('endpoint_cluster_config');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
        } else {
            $action = new Insert('endpoint_cluster_config');
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
