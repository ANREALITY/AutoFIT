<?php
namespace AuditLogging\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AuditLogging\Mvc\Controller\Plugin\AuditLogger;
use DbSystel\DataObject\User;

class AuditLoggerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $auditLogService = $realServiceLocator->get('AuditLogging\Service\AuditLogService');
        $user = new User();
        $userId = $serviceLocator->get('IdentityParam')('id');
        $user->setId($userId);
        $service = new AuditLogger($auditLogService, $user);

        return $service;
    }

}