<?php
namespace Authorization\Acl\Assertion\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Authorization\Acl\Assertion\UserIsOwner;

class UserIsOwnerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileTransferRequestFieldsetService = $container->get('Order\Service\FileTransferRequestService');
        $authenticationService = $container->get('AuthenticationService');
        $userId = ! empty($authenticationService->getIdentity()['id']) ? $authenticationService->getIdentity()['id'] : null;
        $service = new UserIsOwner($userId, $fileTransferRequestFieldsetService);
        return $service;
    }

}
