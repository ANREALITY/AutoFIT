<?php
namespace MasterData\Form\Fieldset\Factory;

use DbSystel\DataObject\Server;
use Interop\Container\ContainerInterface;
use MasterData\Form\Fieldset\ServerAdditionalNameFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServerAdditionalNameFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ServerAdditionalNameFieldset(null, []);
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
