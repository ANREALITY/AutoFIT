<?php
namespace Order\Form\Fieldset\Factory;

use DbSystel\DataObject\Server;
use Interop\Container\ContainerInterface;
use Order\Form\Fieldset\ServerCommonFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

class ServerCommonFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ServerCommonFieldset(null, []);
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Server();
        $fieldset->setObject($prototype);
        $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
        $fieldset->setDbAdapter($dbAdapter);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
