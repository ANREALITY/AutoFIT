<?php
namespace AuditLogging\Controller\Factory;

use AuditLogging\Controller\IndexController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        $formElementManager = $container->get('FormElementManager');
        $auditLogForm = $formElementManager->get('AuditLogging\Form\AuditLogForm');

        $auditLogService = $container->get('AuditLogging\Service\AuditLogService');
        $service = new IndexController($auditLogService);
        $service->setAuditLogForm($auditLogForm);

        return $service;
    }

}
