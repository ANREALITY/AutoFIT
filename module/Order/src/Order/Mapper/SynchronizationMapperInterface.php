<?php
namespace Order\Mapper;

use Base\DataObject\Synchronization;

interface SynchronizationMapperInterface
{

    /**
     * @return Synchronization
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
