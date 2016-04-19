<?php
namespace Order\Service;

use Order\Mapper\NotificationMapperInterface;
use DbSystel\DataObject\Notification;

class NotificationService implements NotificationServiceInterface
{

    /**
     *
     * @var NotificationMapperInterface
     */
    protected $notificationMapper;

    /**
     *
     * @param NotificationMapperInterface $notificationMapper            
     */
    public function __construct(NotificationMapperInterface $notificationMapper)
    {
        $this->notificationMapper = $notificationMapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function findAll()
    {
        return $this->notificationMapper->findAll();
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function find(int $id)
    {
        return $this->notificationMapper->find($id);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function save(Notification $notification)
    {
        return $this->notificationMapper->save($notification);
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function delteAllByLogicalConnection(id $logicalConnectionId)
    {
        return $this->notificationMapper->deleteAll(
            [
                'logical_connection_id' => $logicalConnectionId
            ]);
    }

}
