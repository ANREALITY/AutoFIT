<?php
namespace Order\Mapper;

use DbSystel\DataObject\User;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Hydrator\HydratorInterface;

class UserMapper extends AbstractMapper implements UserMapperInterface
{

    /**
     *
     * @var User
     */
    protected $prototype;

    public function __construct(AdapterInterface $dbAdapter, HydratorInterface $hydrator, User $prototype)
    {
        parent::__construct($dbAdapter, $hydrator, $prototype);
    }

    /**
     *
     * @param int|string $id            
     *
     * @return User
     * @throws \InvalidArgumentException
     */
    public function findOne($id)
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('user');
         * $select->where([
         * 'id = ?' => $id
         * ]);
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
         * return $this->hydrator->hydrate($result->current(), $this->prototype);
         * }
         *
         * throw new \InvalidArgumentException("User with given ID:{$id} not found.");
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @return array|User[]
     */
    public function findAll(array $criteria = [])
    {
        /*
         * $sql = new Sql($this->dbAdapter);
         * $select = $sql->select('user');
         *
         * $statement = $sql->prepareStatementForSqlObject($select);
         * $result = $statement->execute();
         *
         * if ($result instanceof ResultInterface && $result->isQueryResult()) {
         * $resultSet = new HydratingResultSet($this->hydrator, $this->prototype);
         *
         * return $resultSet->initialize($result);
         * }
         *
         * return [];
         */
        throw new \Exception('Method not implemented: ' . __METHOD__);
    }

    /**
     *
     * @param User $dataObject            
     *
     * @return User
     * @throws \Exception
     */
    public function save(User $dataObject)
    {
        // @todo Check, if user exists!
        $data = [];
        // data retrieved directly from the input
        $data['username'] = $dataObject->getUsername();
        // creating sub-objects
        // none
        // data from the recently persisted objects
        // none
        
        $sql = new Sql($this->dbAdapter);
        $select = $select = $sql->select('user');
        $select->where([
            'username = ?' => $data['username']
        ]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface && $result->isQueryResult() && $result->getAffectedRows()) {
            $dataObject = $this->hydrator->hydrate($result->current(), $this->prototype);
            $action = new Update('user');
            $action->set($data);
            $action->where([
                'username' => $data['username']
            ]);
        } else {
            $action = new Insert('user');
            $action->values($data);
        }
        
        $statement = $sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        
        if ($result instanceof ResultInterface) {
            $newId = $result->getGeneratedValue();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
