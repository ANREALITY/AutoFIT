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
    public function find($id);

    /**
     *
     * @return array|Notification[]
     */
    public function findAll(array $criteria = []);

    /**
     *
     * @param Notification $dataObject
     * @return Notification
     * @throws \Exception
     */
    public function save(Notification $dataObject);

    /**
     *
     * @param array $criteria
     * @throws \Exception
     */
    public function deleteAll(array $criteria);

}
