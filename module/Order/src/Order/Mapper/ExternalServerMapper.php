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
