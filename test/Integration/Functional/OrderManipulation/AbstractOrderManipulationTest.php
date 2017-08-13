<?php
namespace Test\Integration\Functional\OrderManipulation;

use DbSystel\DataObject\FileTransferRequest;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Zend\Http\Request;

abstract class AbstractOrderManipulationTest extends AbstractOrderRelatedTest
{

    /**
     * @var string
     */
    const DEFAULT_ADMIN_USERNAME = 'undefined2';

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

    protected function setUp()
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function createOrder(
        string $connectionType, string $endpointSourceType, string $endpointTargetType = null, $reset = true
    ) {
        if ($reset) {
            $this->reset();
        }
        $createUrl = $this->getCreateUrl($connectionType, $endpointSourceType, $endpointTargetType);
        $createParams = $this->getCreateParams($connectionType, $endpointSourceType, $endpointTargetType);
        $this->dispatch($createUrl, Request::METHOD_POST, $createParams);
    }

    protected function changeStatus(
        string $orderId, string $username, string $statusUrlSegment, $reset = true
    ) {
        if ($reset) {
            $this->reset();
        }

        $oldUsername = isset($_SERVER['AUTH_USER']) ? $_SERVER['AUTH_USER'] : null;
        $_SERVER['AUTH_USER'] = $username;

        $changeStatusUrl = '/order/process/' . $statusUrlSegment . '/' . $orderId;
        $this->dispatch($changeStatusUrl);
        $_SERVER['AUTH_USER'] = $oldUsername;
    }

}