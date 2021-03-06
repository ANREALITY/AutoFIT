<?php
namespace AuditLogging\Service;

use Base\DataObject\AuditLog;
use Base\Paginator\Paginator;

interface AuditLogServiceInterface
{

    /**
     * @param int $id Identifier of the AuditLog entry, that should be returned
     * @return AuditLog
     */
    public function findOne($id);

    /**
     * @param array $criteria
     * @param int $page
     * @param array $sorting
     * @return Paginator
     */
    public function findAll(array $criteria = [], $page = null, array $sorting = []);

    /**
     * @param AuditLog $auditLog
     * @return AuditLog
     */
    public function create(AuditLog $auditLog);

}
