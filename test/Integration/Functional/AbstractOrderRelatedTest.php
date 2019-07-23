<?php
namespace Test\Integration\Functional;

use Base\DataObject\FileTransferRequest;
use Base\Test\AbstractControllerTest;
use Base\Test\DatabaseInitializer;
use Zend\Http\PhpEnvironment\Request;

abstract class AbstractOrderRelatedTest extends AbstractControllerTest
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

    protected function getCreateParams(string $connectionType, string $endpointSourceType, string $endpointTargetType = null)
    {
        $endpointTargetType = $endpointTargetType ?: $endpointSourceType;
        $fixturesRootFolder = $this->getApplicationServiceLocator()->get('config')['fixtures']['folder'];
        $fixturesFolder = $fixturesRootFolder . '/' . 'order-create-form-data';
        $fixtureFile = $connectionType . '_' . $endpointSourceType . '_' . $endpointTargetType . '.json';
        $fixtureFilePath = $fixturesFolder . '/' . $fixtureFile;
        $fixtureJson = file_get_contents($fixtureFilePath);
        $createParams = json_decode($fixtureJson, true);
        return $createParams;
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

    protected function getCreateUrl(string $connectionType, string $endpointSourceType, string $endpointTargetType = null)
    {
        $endpointTargetType = $endpointTargetType ?: $endpointSourceType;
        $createUrl = strtolower(
            '/order/process/create'
            . '/' . $connectionType
            . '/' . $endpointSourceType
            . '/' . $endpointTargetType
        );
        return $createUrl;
    }

    protected function changeStatus(
        string $orderId, string $username, string $statusUrlSegment, $reset = true
    ) {
        $oldUsername = isset($_SERVER['AUTH_USER']) ? $_SERVER['AUTH_USER'] : null;
        if ($username) {
            $_SERVER['AUTH_USER'] = $username;
        }

        $changeStatusUrl = '/order/process/' . $statusUrlSegment . '/' . $orderId;
        $this->dispatch($changeStatusUrl);
        if ($oldUsername) {
            $_SERVER['AUTH_USER'] = $oldUsername;
        } else {
            unset($_SERVER['AUTH_USER']);
        }
    }

    protected function setUpDatabase()
    {
        /*
         * Complete database setup for every single test.
         * It makes the tests much, much slower.
         * But so we don't need to care about IDs and duplicated entries.
         */
        $dbConfigs = $this->getApplicationServiceLocator()->get('Config')['db'];
        $databaseInitializer = new DatabaseInitializer($dbConfigs);
        $databaseInitializer->setUp();
        $databaseInitializer->tearDown();
    }

}
