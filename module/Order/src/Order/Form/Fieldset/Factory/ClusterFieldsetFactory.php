<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\ClusterFieldset;
use DbSystel\DataObject\Cluster;
use Interop\Container\ContainerInterface;

class ClusterFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ClusterFieldset(null, []);
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Cluster();
        $fieldset->setObject($prototype);

        $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
        $fieldset->setDbAdapter($dbAdapter);

        return $fieldset;
    }

}
