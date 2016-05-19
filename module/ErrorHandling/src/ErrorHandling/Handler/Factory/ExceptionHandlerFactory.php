<?php
namespace ErrorHandling\Handler\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ErrorHandling\Handler\ExceptionHandler;

class ExceptionHandlerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['errors'];
        $logger = $serviceLocator->get('Logging\Logger\ErrorLogger');
        $showErrorDetails = true;

        if (isset($config['error_details']['restricted']) && !empty($config['error_details']['restricted'])) {
            $authenticationService = $serviceLocator->get($config['error_details']['auth_service_name']);
            $identity = $authenticationService->getIdentity();
            $role = $identity[$config['error_details']['identity_role_key']];
            $errroDetailsAllowed = in_array($role, $config['error_details']['roles']);
            $showErrorDetails = $errroDetailsAllowed;
        }

        $service = new ExceptionHandler($config, $logger, $showErrorDetails);
        return $service;
    }

}
