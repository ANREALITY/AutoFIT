<?php
namespace Order\Mapper;

use DbSystel\DataObject\Notification;

interface NotificationMapperInterface
{

    /**
     *
     * @param int|string $id
     * @return Notification
     * @throws \InvalidArgumentException
     */
    public function findOne($id);

    /**
     *
     * @return array|Notification[]
     */
    public function findAll(array $criteria = []);

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
