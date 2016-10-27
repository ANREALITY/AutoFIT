<?php
namespace AuditLogging\Controller\Factory;

use AuditLogging\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();

        $auditLogService = $realServiceLocator->get('AuditLogging\Service\AuditLogService');
        $service = new IndexController($auditLogService);

        return $service;
    }

}
