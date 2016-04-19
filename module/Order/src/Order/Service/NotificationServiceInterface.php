<?php
namespace Order\Service;

use DbSystel\DataObject\Notification;

interface NotificationServiceInterface
{

    /**
     *
     * @return array|Notification[]
     */
    public function findAll();

    /**
     *
     * @param int $id
     *            Identifier of the Notification that should be returned
     * @return Notification
     */
    public function find(int $id);

    /**
     *
     * @param Notification $notification
     * @return Notification
     */
    public function save(Notification $notification);

    /**
     *
     * @param int $logicalConnectionId
     */
    public function delteAllByLogicalConnection(int $logicalConnectionId);

}
