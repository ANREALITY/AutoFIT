<?php
namespace Order\Mapper;

use DbSystel\DataObject\Synchronization;

interface SynchronizationMapperInterface
{

    /**
     *
     * @return Synchronization
     * @throws \InvalidArgumentException
     */
    public function findAll();

}
