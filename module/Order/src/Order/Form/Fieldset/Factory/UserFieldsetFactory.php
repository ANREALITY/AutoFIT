<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\UserFieldset;
use Base\DataObject\User;
use Interop\Container\ContainerInterface;

class UserFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('AuthenticationService');
        $username = $authenticationService->getIdentity()['username'];

        $fieldset = new UserFieldset(null, [], $username);
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new User();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
