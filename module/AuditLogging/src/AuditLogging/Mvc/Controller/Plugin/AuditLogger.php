<?php
namespace AuditLogging\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DbSystel\DataObject\AuditLog;
use AuditLogging\Service\AuditLogServiceInterface;

class AuditLogger extends AbstractPlugin
{

    protected $auditLogService;

    public function __construct(AuditLogServiceInterface $auditLogService)
    {
        $this->auditLogService = $auditLogService;
    }

    public function log(AuditLog $auditLog)
    {
        $this->auditLogService->saveOne($auditLog);
    }
    
}
