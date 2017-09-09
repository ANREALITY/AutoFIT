<?php
namespace Order\Mapper;

use DbSystel\DataObject\Synchronization;

class SynchronizationMapper extends AbstractMapper implements SynchronizationMapperInterface
{

    /** @var string for the findOne(...) */
    const ENTITY_TYPE = Synchronization::class;

    /**
     * @inheritdoc
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(static::ENTITY_TYPE, 's');

        $queryBuilder->setMaxResults($limit ?: null);

        $query = $queryBuilder->getQuery();
        $result = $query->execute(null, $hydrationMode);

        return $result;
    }
}
