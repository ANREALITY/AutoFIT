<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\ServerListItemFieldset;
use DbSystel\DataObject\Server;
use Interop\Container\ContainerInterface;

class ServerListItemFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ServerListItemFieldset(null, []);
        $hydrator = $container->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Server();
        $fieldset->setObject($prototype);

        $dbAdapter = $container->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $fieldset->setDbAdapter($dbAdapter);

        return $fieldset;
    }

}
