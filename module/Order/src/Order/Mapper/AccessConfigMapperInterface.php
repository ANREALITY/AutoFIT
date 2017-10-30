<?php
namespace Order\Mapper;

use DbSystel\DataObject\AccessConfig;

interface AccessConfigMapperInterface
{

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
