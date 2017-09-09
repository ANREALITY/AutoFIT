<?php
namespace Order\Mapper;

use DbSystel\DataObject\Customer;
use Doctrine\ORM\EntityManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class CustomerMapper extends AbstractMapper implements CustomerMapperInterface
{

    /**
     *
     * @param Customer $dataObject
     *
     * @return Customer
     * @throws \Exception
     */
    public function save(Customer $dataObject)
    {
        // @todo Check, if customer exists!
        $data = [];
        // data retrieved directly from the input
        $data['id'] = $dataObject->getId();
        $data['name'] = $dataObject->getName();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none

        if (! $data['id']) {
            $action = new Insert('customer');
            $action->values($data);
        } else {
            $action = new Update('customer');
            $action->where(['id' => $data['id']]);
            unset($data['id']);
            $action->set($data);
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
