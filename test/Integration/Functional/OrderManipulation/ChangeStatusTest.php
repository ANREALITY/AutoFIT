<?php
namespace Test\Integration\Functional\OrderManipulation;

use Authorization\Acl\Acl;
use Order\Service\UserService;

class ChangeStatusTest extends AbstractOrderManipulationTest
{

    /**
     * Testing the order status changes workflow
     * edit->pending->edit->canceled
     * made by the member (by the example of the cd_cdas400_cdas400).
     */
    public function testWorkflowEditPendingEditCanceled()
    {
        $this->createOrder('cd', 'cdas400');

        $orderId = 1;

        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'submit');
        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'start-editing');
        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'cancel');
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

        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'start-editing');
        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'cancel');
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

        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'submit');
        $this->assertStatusChange($orderId, self::DEFAULT_ADMIN_USERNAME, 'start-checking');
        $this->assertStatusChange($orderId, self::DEFAULT_ADMIN_USERNAME, 'accept');
        $this->assertStatusChange($orderId, self::DEFAULT_ADMIN_USERNAME, 'complete');
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

        $this->assertStatusChange($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'submit');
        $this->assertStatusChange($orderId, self::DEFAULT_ADMIN_USERNAME, 'start-checking');
        $this->assertStatusChange($orderId, self::DEFAULT_ADMIN_USERNAME, 'decline');
    }

    protected function assertStatusChange($orderId, $username, $statusUrlSegment)
    {
        $this->reset();
        $this->changeStatus($orderId, $username, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$statusUrlSegment], $actualData['status']);
    }

}
