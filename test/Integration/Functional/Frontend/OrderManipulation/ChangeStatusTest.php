<?php
namespace Test\Integration\Functional\Frontend\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use Order\Form\OrderForm;
use Zend\Http\Request;

class ChangeStatusTest extends AbstractOrderManipulationTest
{

    static protected $actionsToStatusesMap = [
        // member
        'start-editing' => FileTransferRequest::STATUS_EDIT,
        'submit' => FileTransferRequest::STATUS_PENDING,
        'cancel' => FileTransferRequest::STATUS_CANCELED,
        // admin
        'start-checking' => FileTransferRequest::STATUS_CHECK,
        'accept' => FileTransferRequest::STATUS_ACCEPTED,
        'decline' => FileTransferRequest::STATUS_DECLINED,
        'complete' => FileTransferRequest::STATUS_COMPLETED,
    ];

    /**
     * Testing the order status changes made by the frontend user (by the example of the cd_cdas400_cdas400).
     */
    public function testProcessForUser()
    {
        $this->createOrder('cd', 'cdas400');

        $this->reset();

        $orderId = 1;
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(FileTransferRequest::STATUS_EDIT, $actualData['status']);

        $statusUrlSegment = 'submit';
        $this->changeStatus($orderId, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$statusUrlSegment], $actualData['status']);

        $statusUrlSegment = 'start-editing';
        $this->changeStatus($orderId, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$statusUrlSegment], $actualData['status']);

        $statusUrlSegment = 'cancel';
        $this->changeStatus($orderId, $statusUrlSegment);
        $actualData = $this->retrieveActualData('file_transfer_request', 'id', $orderId);
        $this->assertEquals(self::$actionsToStatusesMap[$statusUrlSegment], $actualData['status']);
    }

    protected function changeStatus(
        string $orderId, string $statusUrlSegment, $reset = true
    ) {
        if ($reset) {
            $this->reset();
        }
        $changeStatusUrl = '/order/process/' . $statusUrlSegment . '/' . $orderId;
        $this->dispatch($changeStatusUrl);
    }

}
