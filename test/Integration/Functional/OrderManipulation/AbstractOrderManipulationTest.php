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

}