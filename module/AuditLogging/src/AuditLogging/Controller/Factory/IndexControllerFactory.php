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

        $formElementManager = $realServiceLocator->get('FormElementManager');
        $auditLogForm = $formElementManager->get('AuditLogging\Form\AuditLogForm');

        $auditLogService = $realServiceLocator->get('AuditLogging\Service\AuditLogService');
        $service = new IndexController($auditLogService);
        $service->setAuditLogForm($auditLogForm);

        return $service;
    }

}
