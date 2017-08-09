<?php
namespace Test\Integration\Functional\OrderManipulation;

use Authorization\Acl\Acl;
use DbSystel\DataObject\FileTransferRequest;
use DbSystel\Test\AbstractControllerTest;
use DbSystel\Test\DatabaseInitializer;
use Zend\Db\Sql\Sql;
use Zend\Http\Request;

abstract class AbstractOrderManipulationTest extends AbstractControllerTest
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

    protected function retrieveActualData($table, $idColumn, $idValue)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select($table);
        $select->where([$table . '.' . $idColumn . ' = ?' => $idValue]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $data = $result->current();
        return $data;
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
    }

    protected function tearDown()
    {
        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $prop) {
            if (!$prop->isStatic() && 0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        unset($_SERVER['AUTH_USER']);
    }

    protected function changeStatus(
        string $orderId, string $statusUrlSegment, $reset = true
    ) {
        if ($reset) {
            $this->reset();
        }
        $userModified = false;
        if (array_key_exists($statusUrlSegment, self::$actionsToStatusesMap[Acl::ROLE_ADMIN])) {
            $_SERVER['AUTH_USER'] = 'undefined2';
            $userModified = true;
        }
        $changeStatusUrl = '/order/process/' . $statusUrlSegment . '/' . $orderId;
        $this->dispatch($changeStatusUrl);
        if ($userModified) {
            unset($_SERVER['AUTH_USER']);
        }
    }

}