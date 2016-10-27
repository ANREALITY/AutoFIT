<?php
namespace AuditLogging\Service;

use DbSystel\DataObject\AuditLog;

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
    public function findAll();

    /**
     *
     * @param AuditLog $auditLog
     * @return AuditLog
     */
    public function saveOne(AuditLog $auditLog);

}