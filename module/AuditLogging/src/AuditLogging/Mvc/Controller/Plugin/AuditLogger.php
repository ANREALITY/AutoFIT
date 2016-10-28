<?php
namespace AuditLogging\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use DbSystel\DataObject\AuditLog;
use AuditLogging\Service\AuditLogServiceInterface;
use DbSystel\DataObject\User;

class AuditLogger extends AbstractPlugin
{

    /**
     * @var AuditLogServiceInterface
     */
    protected $auditLogService;

    /**
     * @var User
     */
    protected $user;

    public function __construct(AuditLogServiceInterface $auditLogService, User $user = null)
    {
        $this->auditLogService = $auditLogService;
        $this->user = $user;
    }

    public function log($resourceType = null, $resourceId = null, $action = null, $userId = null)
    {
        $auditLog = new AuditLog();
        $auditLog->setResourceType($resourceType);
        $auditLog->setResourceId($resourceId);
        $auditLog->setAction($action);
        if ($userId) {
            $user = new User();
            $user->setId($userId);
            $auditLog->setUser($user);
        } elseif ($this->user) {
            $auditLog->setUser($this->user);
        }
        $this->auditLogService->saveOne($auditLog);
    }
    
}
