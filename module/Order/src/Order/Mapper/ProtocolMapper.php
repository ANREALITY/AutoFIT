<?php
namespace Order\Mapper;

use DbSystel\DataObject\Protocol;
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

class ProtocolMapper extends AbstractMapper implements ProtocolMapperInterface
{

    public function deleteAll(array $criteria)
    {
        $action = new Delete('protocol');

        $return = false;
        $conditionGiven = false;

        if (! empty($criteria)) {
            foreach ($criteria as $condition) {
                if (is_array($condition)) {
                    if (! empty($condition['protocol_set_id'])) {
                        $action->where(
                            [
                                'protocol_set_id = ?' => $condition['protocol_set_id']
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
