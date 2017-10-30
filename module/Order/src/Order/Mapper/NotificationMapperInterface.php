<?php
namespace Order\Mapper;

use DbSystel\DataObject\Notification;

interface NotificationMapperInterface
{

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
