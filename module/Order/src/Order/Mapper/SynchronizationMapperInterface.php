<?php
namespace Order\Mapper;

use DbSystel\DataObject\Synchronization;

interface SynchronizationMapperInterface
{

    /**
     * @return Synchronization
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
