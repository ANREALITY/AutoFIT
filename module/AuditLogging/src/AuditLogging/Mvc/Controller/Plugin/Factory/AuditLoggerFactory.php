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
        $service = new AuditLogger($auditLogService, $user);

        return $service;
    }

}
