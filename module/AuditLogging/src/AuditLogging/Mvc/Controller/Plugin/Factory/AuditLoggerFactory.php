<?php
namespace AuditLogging\Mvc\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AuditLogging\Mvc\Controller\Plugin\AuditLogger;

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
        
        return new AuditLogger($auditLogService);
    }

}
