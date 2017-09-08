<?php
namespace Order\Mapper;

use DbSystel\DataObject\User;
use Doctrine\ORM\EntityManager;
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

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = User::class;

    /**
     *
     * @var User
     */
    protected $prototype;

    /**
     * @param string $username
     * @return User
     */
    public function findOneByUsername(string $username)
    {
        $repository = $this->entityManager->getRepository(static::ENTITY_TYPE);
        /** @var User $entity */
        $entity = $repository->findOneBy(['username' => $username]);
        return $entity;
    }

    /**
     *
     * @return array|User[]
     */
    public function findAll(array $criteria = [])
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('user');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (! empty($condition['username'])) {
                    $select->where(
                        [
                            'username LIKE ?' => '%' . $condition['username'] . '%'
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
            $dataObject = $this->hydrator->hydrate($result->current(), $this->getPrototype());
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
            $newId = $result->getGeneratedValue() ?: $dataObject->getId();
            if ($newId) {
                $dataObject->setId($newId);
            }
            return $dataObject;
        }
        throw new \Exception('Database error in ' . __METHOD__);
    }

}
