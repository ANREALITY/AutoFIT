<?php
namespace Order\Mapper;

use DbSystel\DataObject\User;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;

class UserMapper extends AbstractMapper implements UserMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = User::class;

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
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')->from(static::ENTITY_TYPE, 'u');

        foreach ($criteria as $condition) {
            if (is_array($condition)) {
                if (array_key_exists('username', $condition)) {
                    $queryBuilder
                        ->where('u.username LIKE :username')
                        ->setParameter('username', '%' . $condition['username'] . '%')
                    ;
                }
            }
        }

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
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

        $currentUser = $this->findOneByUsername($data['username']);

        if ($currentUser instanceof User) {
            $this->entityManager->refresh($currentUser);
            $dataObject = $currentUser;
            $action = new Update('user');
            $action->set($data);
            $action->where([
                'username' => $data['username']
            ]);
        } else {
            $action = new Insert('user');
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
