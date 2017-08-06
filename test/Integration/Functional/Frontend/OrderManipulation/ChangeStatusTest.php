<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use Authorization\Acl\Acl;
use DbSystel\DataObject\FileTransferRequest;
use Order\Form\OrderForm;
use Zend\Http\Request;

class ChangeStatusTest extends AbstractOrderManipulationTest
{

    static protected $actionsToStatusesMap = [
        Acl::ROLE_MEMBER => [
            'start-editing' => FileTransferRequest::STATUS_EDIT,
            'submit' => FileTransferRequest::STATUS_PENDING,
            'cancel' => FileTransferRequest::STATUS_CANCELED,
        ],
        Acl::ROLE_ADMIN => [
            'start-checking' => FileTransferRequest::STATUS_CHECK,
            'accept' => FileTransferRequest::STATUS_ACCEPTED,
            'decline' => FileTransferRequest::STATUS_DECLINED,
            'complete' => FileTransferRequest::STATUS_COMPLETED,
        ]
    ];

    /**
     * Testing the order status changes workflow
     * edit->pending->edit->canceled
     * made by the member (by the example of the cd_cdas400_cdas400).
     */
    public function testWorkflowEditPendingEditCanceled()
    {
        $this->createOrder('cd', 'cdas400');

        $orderId = 1;

        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'submit');
        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'start-editing');
        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'cancel');
    }

    /**
     * Testing the order status changes workflow
     * edit->pending->canceled
     * made by the member (by the example of the cd_cdas400_cdas400).
     */
    public function testWorkflowEditEditCanceled()
    {
        $this->createOrder('cd', 'cdas400');

        $orderId = 1;

        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'start-editing');
        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'cancel');
    }

    /**
     * Testing the order status changes workflow
     * edit->pending->check->accepted->completed
     * made by the admin (by the example of the cd_cdas400_cdas400).
     */
    public function testWorkflowEditPendingCheckAcceptedCompleted()
    {
        $this->createOrder('cd', 'cdas400');

        $orderId = 1;

        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'submit');
        $this->assertStatusChange($orderId, Acl::ROLE_ADMIN, 'start-checking');
        $this->assertStatusChange($orderId, Acl::ROLE_ADMIN, 'accept');
        $this->assertStatusChange($orderId, Acl::ROLE_ADMIN, 'complete');
    }

    /**
     * Testing the order status changes workflow
     * edit->pending->check->declined
     * made by the admin (by the example of the cd_cdas400_cdas400).
     */
    public function testWorkflowEditPendingCheckDeclined()
    {
        $this->createOrder('cd', 'cdas400');

        $orderId = 1;

        $this->assertStatusChange($orderId, Acl::ROLE_MEMBER, 'submit');
        $this->assertStatusChange($orderId, Acl::ROLE_ADMIN, 'start-checking');
        $this->assertStatusChange($orderId, Acl::ROLE_ADMIN, 'decline');
    }

    protected function assertStatusChange($orderId, $role, $statusUrlSegment)
    {
        $this->changeStatus($orderId, $role, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$role][$statusUrlSegment], $actualData['status']);
    }

    protected function changeStatus(
        string $orderId, $role, string $statusUrlSegment, $reset = true
    ) {
        if ($reset) {
            $this->reset();
        }
        if (array_key_exists($statusUrlSegment, self::$actionsToStatusesMap[Acl::ROLE_ADMIN])) {
            $_SERVER['AUTH_USER'] = 'undefined2';
        }
        $changeStatusUrl = '/order/process/' . $statusUrlSegment . '/' . $orderId;
        $this->dispatch($changeStatusUrl);
    }

}
