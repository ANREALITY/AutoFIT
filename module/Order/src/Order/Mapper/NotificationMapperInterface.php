<?php
namespace Order\Mapper;

use DbSystel\DataObject\Notification;

interface NotificationMapperInterface
{

    /**
     *
     * @param Notification $dataObject
     * @param boolean $updateIfIdSet
     * @return Notification
     * @throws \Exception
     */
    public function save(Notification $dataObject, bool $updateIfIdSet = false);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
