<?php
namespace AuditLogging\Mvc\Controller\Plugin;

use Base\DataObject\AuditLogCluster;
use Base\DataObject\AuditLogFileTransferRequest;
use Base\DataObject\AuditLogServer;
use Order\Service\ClusterServiceInterface;
use Order\Service\FileTransferRequestServiceInterface;
use Order\Service\ServerServiceInterface;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Base\DataObject\AuditLog;
use AuditLogging\Service\AuditLogServiceInterface;
use Base\DataObject\User;

class AuditLogger extends AbstractPlugin
{

    /**
     * @var AuditLogServiceInterface
     */
    protected $auditLogService;
    /**
     * @var FileTransferRequestServiceInterface
     */
    protected $fileTransferRequestService;
    /**
     * @var ServerServiceInterface
     */
    protected $serverService;
    /**
     * @var ClusterServiceInterface
     */
    protected $clusterService;

    /**
     * @var User
     */
    protected $user;

    public function __construct(
        AuditLogServiceInterface $auditLogService,
        User $user = null,
        FileTransferRequestServiceInterface $fileTransferRequestService,
        ServerServiceInterface $serverService,
        ClusterServiceInterface $clusterService
    ) {
        $this->auditLogService = $auditLogService;
        $this->user = $user;
        $this->fileTransferRequestService = $fileTransferRequestService;
        $this->serverService = $serverService;
        $this->clusterService = $clusterService;
    }

    public function log($resourceType = null, $resourceId = null, $action = null, $userId = null)
    {
        switch ($resourceType) {
            case AuditLog::RESSOURCE_TYPE_ORDER:
                $auditLog = new AuditLogFileTransferRequest();
                $resource = $this->fileTransferRequestService->findOne($resourceId);
                $auditLog->setFileTransferRequest($resource);
                break;
            case AuditLog::RESSOURCE_TYPE_SERVER:
                $auditLog = new AuditLogServer();
                $resource = $this->serverService->findOne($resourceId);
                $auditLog->setServer($resource);
                break;
            case AuditLog::RESSOURCE_TYPE_CLUSTER:
                $auditLog = new AuditLogCluster();
                $resource = $this->clusterService->findOne($resourceId);
                $auditLog->setCluster($resource);
                break;
            default:
                $auditLog = new AuditLog();
        }
        $auditLog->setAction($action);
        if ($userId) {
            $user = new User();
            $user->setId($userId);
            $auditLog->setUser($user);
        } elseif ($this->user) {
            $auditLog->setUser($this->user);
        }
        $this->auditLogService->create($auditLog);
    }
    
}
