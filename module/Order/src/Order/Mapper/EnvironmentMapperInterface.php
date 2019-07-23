<?php
namespace Order\Mapper;

use Base\DataObject\Environment;

interface EnvironmentMapperInterface
{

    /**
     *
     * @return array|Environment[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
