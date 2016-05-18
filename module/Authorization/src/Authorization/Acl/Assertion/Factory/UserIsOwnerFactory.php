<?php
namespace Authorization\Acl\Assertion\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Authorization\Acl\Assertion\UserIsOwner;

class UserIsOwnerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fileTransferRequestFieldsetService = $serviceLocator->get('Order\Service\FileTransferRequestService');
        $authenticationService = $serviceLocator->get('AuthenticationService');
        $userId = ! empty($authenticationService->getIdentity()['id']) ? $authenticationService->getIdentity()['id'] : null;
        $service = new UserIsOwner($userId, $fileTransferRequestFieldsetService);
        return $service;
    }

}
