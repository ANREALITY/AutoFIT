<?php
namespace Order\Mapper;

use Base\DataObject\Draft;
use Base\DataObject\User;

class DraftMapper extends AbstractMapper implements DraftMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Draft::class;

    /**
     *
     * @param Draft $draft
     *
     * @return Draft
     * @throws \Exception
     */
    public function save(Draft $draft)
    {
        $this->entityManager->persist($draft);
        $this->entityManager->flush();

        return $draft;
    }

    /**
     * @param User $user
     * @return Draft
     */
    public function findOneByUser(User $user)
    {
        $repository = $this->entityManager->getRepository(static::ENTITY_TYPE);
        /** @var Draft $entity */
        $entity = $repository->findOneBy(['user' => $user]);
        return $entity;
    }

    /**
     * @param User $user
     * @return void
     */
    public function removeAllByUser(User $user)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Draft::class, 'd');
        $queryBuilder->where('d.user = :user');
        $queryBuilder->setParameter('user', $user);
        $query = $queryBuilder->getQuery();
        $query->execute();
    }

}
