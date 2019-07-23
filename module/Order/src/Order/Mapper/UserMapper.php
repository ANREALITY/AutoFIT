<?php
namespace Order\Mapper;

use Base\DataObject\User;

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
     * @param User $dataObject
     * @return User
     */
    public function save(User $dataObject)
    {
        $this->entityManager->persist($dataObject);
        $this->entityManager->flush();

        return $dataObject;
    }

}
