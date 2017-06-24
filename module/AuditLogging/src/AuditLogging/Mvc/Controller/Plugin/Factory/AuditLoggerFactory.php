<?php
namespace AuditLogging\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use AuditLogging\Mvc\Controller\Plugin\AuditLogger;
use DbSystel\DataObject\User;

class AuditLoggerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();

        $auditLogService = $realServiceLocator->get('AuditLogging\Service\AuditLogService');
        $user = new User();
        $userId = $container->get('IdentityParam')('id');
        $user->setId($userId);
        $service = new AuditLogger($auditLogService, $user);

        return $service;
    }

}
