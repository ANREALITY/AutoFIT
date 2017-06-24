<?php
namespace MasterData\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use MasterData\Form\Fieldset\ServerAdditionalNameFieldset;
use DbSystel\DataObject\Server;
use Interop\Container\ContainerInterface;

class ServerAdditionalNameFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ServerAdditionalNameFieldset(null, []);
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
