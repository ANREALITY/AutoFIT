<?php
namespace Order\Form\Fieldset\Factory;

use Base\DataObject\Server;
use Interop\Container\ContainerInterface;
use Order\Form\Fieldset\ServerListItemFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServerListItemFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ServerListItemFieldset(null, []);
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Server();
        $fieldset->setObject($prototype);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
