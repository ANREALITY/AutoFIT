<?php
namespace Order\Mapper;

use DbSystel\DataObject\Application;

interface ApplicationMapperInterface
{

    /**
     *
     * @return array|Application[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
