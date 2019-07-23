<?php
namespace Order\Service;

use Base\DataObject\Synchronization;

interface SynchronizationServiceInterface
{

    /**
     *
     * @return Synchronization
     */
    public function findAll();

}
