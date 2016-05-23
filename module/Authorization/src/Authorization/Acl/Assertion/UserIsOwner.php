<?php
namespace Authorization\Acl\Assertion;

use Zend\Permissions\Acl\Assertion\AssertionInterface;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Order\Service\FileTransferRequestService;

class UserIsOwner implements AssertionInterface
{

    /**
     *
     * @var integer
     */
    protected $userId;

    /**
     *
     * @var FileTransferRequestService
     */
    protected $fileTransferRequestService;

    public function __construct(int $userId = null, FileTransferRequestService $fileTransferRequestService)
    {
        $this->userId = $userId;
        $this->fileTransferRequestService = $fileTransferRequestService;
    }

    public function assert(Acl $acl, RoleInterface $role = null, ResourceInterface $resource = null, $privilege = null)
    {
        return isset($resource->getParams()['id']) ? $this->isUserOwner($resource->getParams()['id']) : false;
    }

    protected function isUserOwner($orderId = null)
    {
        $order = $this->fileTransferRequestService->findOne($orderId);
        $orderOwnerId = $order->getUser()->getId();
        return $this->userId == $orderOwnerId;
    }

}
