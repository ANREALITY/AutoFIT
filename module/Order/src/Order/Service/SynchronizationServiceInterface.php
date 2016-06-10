<?php
namespace Order\Service;

use DbSystel\DataObject\Synchronization;

interface SynchronizationServiceInterface
{

    /**
     *
     * @return Synchronization
     */
    public function findAll();

}
