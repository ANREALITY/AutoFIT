<?php
namespace FileTransferRequest\Mapper;

use DbSystel\DataObject\Customer;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class CustomerMapper implements CustomerMapperInterface
{

    /**
     *
     * @var \Zend\Db\Adapter\AdapterInterface
     */
    protected $dbAdapter;

    /**
     *
     * @var \Zend\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     *
     * @var Customer
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, Customer $prototype)
    {
        $this->dbAdapter = $dbAdapter;
        $this->hydrator = $hydrator;
        $this->prototype = $prototype;
    }

    /**
     *
     * @param int|string $id            
     *
     * @return Customer
     * @throws \InvalidArgumentException
     */
    public function find($id)
    {
        /*
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('customer');
        $select->where(array(
            'id = ?' => $id
        ));
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            return $this->hydrator->hydrate($result->current(), $this->prototype);
        }
        
        throw new \InvalidArgumentException("Customer with given ID:{$id} not found.");
        */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|Customer[]
     */
    public function findAll()
    {
        /*
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('customer');
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
            
            return $resultSet->initialize($result);
        }
        
        return array();
        */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param Customer $dataObject            
     *
     * @return Customer
     * @throws \Exception
     */
    public function save(Customer $dataObject)
    {
        $customerData = $this->hydrator->extract($dataObject);
        unset($customerData['id']);

        if ($dataObject->getId()) {
            $action = new Update('customer');
            $action->set($customerData);
            $action->where(array(
                'id = ?' => $dataObject->getId()
            ));
        } else {
            $action = new Insert('customer');
            $action->values($customerData);
        }

        $sql = new Sql($this->dbAdapter);
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();

        if ($result instanceof ResultInterface) {
            if ($newId = $result->getGeneratedValue()) {
                $dataObject->setId($newId);
            }

            return $dataObject;
        }

        throw new \Exception("Database error");
    }
}
