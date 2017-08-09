<?php
namespace Test\Integration\Functional\OrderManipulation;

use Authorization\Acl\Acl;

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
        $this->changeStatus($orderId, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$role][$statusUrlSegment], $actualData['status']);
    }

}
