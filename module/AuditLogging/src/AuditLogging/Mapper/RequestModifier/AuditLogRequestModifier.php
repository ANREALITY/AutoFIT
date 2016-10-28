<?php
namespace AuditLogging\Mapper\RequestModifier;

use Zend\Db\Sql\Expression;
use DbSystel\DataObject\AuditLog;
use Zend\Db\Sql\Select;
class AuditLogRequestModifier
{

    const REQUEST_MODE_BASIC = 'basic';

    const REQUEST_MODE_REDUCED = 'reduced';

    const REQUEST_MODE_FULL = 'full';

    public function addFileTransferRequest(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('file_transfer_request', new Expression(
            'audit_log.resource_type = \'' . AuditLog::RESSOURCE_TYPE_ORDER . '\' AND file_transfer_request.id = audit_log.resource_id'),
            [
                'file_transfer_request' . '__' . 'id' => 'id',
                'file_transfer_request' . '__' . 'change_number' => 'change_number'
            ], Select::JOIN_LEFT);
    }

}
