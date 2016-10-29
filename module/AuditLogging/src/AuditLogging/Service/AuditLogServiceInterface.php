<?php
namespace AuditLogging\Service;

use DbSystel\DataObject\AuditLog;
use AuditLogging\Mapper\RequestModifier\AuditLogRequestModifier;

interface AuditLogServiceInterface
{

    /**
     *
     * @param int $id
     *            Identifier of the AuditLog that should be returned
     * @return AuditLog
     */
    public function findOne($id);

    /**
     *
     * @return AuditLog[]
     */
    public function findAllWithBuldledData(array $criteria = [], $id = null, $page = null, $requstMode = AuditLogRequestModifier::REQUEST_MODE_REDUCED, array $sorting = []);

    /**
     *
     * @param AuditLog $auditLog
     * @return AuditLog
     */
    public function saveOne(AuditLog $auditLog);

}
