<?php
namespace Test\Integration\Functional\AuditLog;

use DbSystel\DataObject\AuditLog;
use DbSystel\Paginator\Paginator;
use Order\Service\UserService;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Hydrator\ClassMethods;

class AuditLogRecordingAndRetrievingTest extends AbstractOrderRelatedTest
{

    /**
     * @var int
     */
    const ITEMS_PER_PAGE = 3;

    public function testCreateLogEntryOnEvent()
    {
        $orderId = 1;
        $this->createLogEntriesForTesting($orderId);
        $this->assertCreateLogEntryOnEvent($orderId);
        $this->assertRetrievingLogEntries();
    }

    protected function assertCreateLogEntryOnEvent(int $orderId)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select('audit_log');
        $select->where([
            'audit_log.resource_type = ?' => AuditLog::RESSOURCE_TYPE_ORDER,
            'audit_log.resource_id = ?' => $orderId,
        ]);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $hydrator = new ClassMethods();
        $resultSet = new HydratingResultSet($hydrator, new AuditLog());
        $data = $resultSet->initialize($result);

        /** @var AuditLog[] $auditLogEntries */
        $auditLogEntries = [];
        /** @var AuditLog $auditLogEntry */
        foreach ($data as $auditLogEntry) {
            $auditLogEntries[] = $auditLogEntry;
        }

        $this->assertEquals(6, $data->count());
        $expectedData = [
            [
                'id' => 1,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
            [
                'id' => 2,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
            [
                'id' => 3,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
            [
                'id' => 4,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
            [
                'id' => 5,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
            [
                'id' => 6,
                'resource_type' => AuditLog::RESSOURCE_TYPE_ORDER,
                'resource_id' => 1,
            ],
        ];
        $counter = 0;
        foreach ($auditLogEntries as $auditLogEntry) {
            $this->assertEquals($auditLogEntry->getId(), $expectedData[$counter]['id']);
            $this->assertEquals($auditLogEntry->getResourceId(), $expectedData[$counter]['resource_id']);
            $this->assertEquals($auditLogEntry->getResourceType(), $expectedData[$counter]['resource_type']);
            $counter++;
        }
    }

    protected function assertRetrievingLogEntries()
    {
        $this->reset();
        $_SERVER['AUTH_USER'] = 'undefined';
        $auditLogUrl = '/audit-logging/list';
        $this->dispatch($auditLogUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertModuleName('AuditLogging');
        $this->assertControllerName('AuditLogging\Controller\Index');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('list');

        // list audit log entries
        $this->reset();
        $_SERVER['AUTH_USER'] = 'undefined2';
        $auditLogUrl = '/audit-logging/list';
        $this->dispatch($auditLogUrl);
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        /** @var Paginator $paginator */
        $paginator = $this->getApplication()->getMvcEvent()->getResult()->getVariable('paginator', null);
        $entiresTotalNumber = 6;
        $this->assertEquals($entiresTotalNumber, $paginator->getTotalItemCount());
        /** @var AuditLog[] $currentEntries */
        $currentEntries = $paginator->getCurrentItems();
        $currentEntry = reset($currentEntries);
        $this->assertEquals($currentEntry->getResourceId(), 1);
        $this->assertEquals($currentEntry->getResourceType(), AuditLog::RESSOURCE_TYPE_ORDER);

        // list audit log entries filterred
        $this->reset();
        $_SERVER['AUTH_USER'] = 'undefined2';
        $auditLogUrl = '/audit-logging/list' . '?'
            . 'filter[username]=' . 'undefined2'
            . '&' . 'filter[change_number]=' . 'C00000011'
            . '&' . 'filter[resource_type]=' . AuditLog::RESSOURCE_TYPE_ORDER
        ;
        $this->dispatch($auditLogUrl);
        /** @var Paginator $paginator */
        $paginator = $this->getApplication()->getMvcEvent()->getResult()->getVariable('paginator', null);
        $entiresTotalNumber = 3;
        $this->assertEquals($entiresTotalNumber, $paginator->getTotalItemCount());
        /** @var AuditLog[] $currentEntries */
        $currentEntries = $paginator->getCurrentItems();
        $this->assertEquals($entiresTotalNumber, count($currentEntries));
        $firstEntry = reset($currentEntries);
        $this->assertEquals(1, $firstEntry->getResourceId());
        $this->assertEquals(AuditLog::RESSOURCE_TYPE_ORDER, $currentEntries[0]->getResourceType());

    }

    protected function createLogEntriesForTesting(int $orderId)
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $createParams = $this->getCreateParams($connectionType, $endpointSourceType);
        $editParams = $createParams;
        $editParams['file_transfer_request']['id'] = $orderId;
        $editedComment = 'edited comment...';
        $editParams['file_transfer_request']['comment'] = $editedComment;
        $editUrl = '/order/process/edit/' . $orderId;
        $this->dispatch($editUrl, Request::METHOD_POST, $editParams);

        $this->reset();

        $this->changeStatus($orderId, UserService::DEFAULT_MEMBER_USERNAME, 'submit');
        $this->reset();
        $this->changeStatus($orderId, self::DEFAULT_ADMIN_USERNAME, 'start-checking');
        $this->reset();
        $this->changeStatus($orderId, self::DEFAULT_ADMIN_USERNAME, 'accept');
        $this->reset();
        $this->changeStatus($orderId, self::DEFAULT_ADMIN_USERNAME, 'complete');
    }

}
