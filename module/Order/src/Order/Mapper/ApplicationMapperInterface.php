<?php
namespace Order\Mapper;

use Base\DataObject\Application;

interface ApplicationMapperInterface
{

    /**
     *
     * @return array|Application[]
     */
    public function findAll(array $criteria = [], int $limit = null, int $hydrationMode = null);

}
