<?php
namespace Order\Mapper;

use DbSystel\DataObject\Environment;

interface EnvironmentMapperInterface
{

    /**
     *
     * @return array|Environment[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
