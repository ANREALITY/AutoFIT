<?php
namespace AuditLogging\Mvc\Controller\Plugin\Factory;

use AuditLogging\Mvc\Controller\Plugin\AuditLogger;
use DbSystel\DataObject\User;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuditLoggerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $auditLogService = $container->get('AuditLogging\Service\AuditLogService');
        $user = new User();
        $userId = $container->get(PluginManager::class)->get('IdentityParam')('id');
        $user->setId($userId);
        $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');
        $serverService = $container->get('Order\Service\ServerService');
        $clusterService = $container->get('Order\Service\ClusterService');
        $service = new AuditLogger(
            $auditLogService,
            $user,
            $fileTransferRequestService,
            $serverService,
            $clusterService
        );

        return $service;
    }

}
