<?php
namespace Test\Integration\Functional\AuditLog;

use DbSystel\DataObject\AuditLog;
use Order\Service\UserService;
use Test\Integration\Functional\AbstractOrderRelatedTest;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Sql;
use Zend\Http\Request;
use Zend\Hydrator\ClassMethods;

class AuditLogRecordingTest extends AbstractOrderRelatedTest
{

    public function testCreateLogEntryOnEvent()
    {
        $connectionType = 'cd';
        $endpointSourceType = 'cdas400';
        $this->createOrder($connectionType, $endpointSourceType);

        $this->reset();

        $orderId = 1;
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

        /** @var AuditLog[] */
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

}
