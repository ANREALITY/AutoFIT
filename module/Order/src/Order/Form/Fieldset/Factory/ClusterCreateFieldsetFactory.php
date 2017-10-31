<?php
namespace Order\Form\Fieldset\Factory;

use DbSystel\DataObject\Cluster;
use Interop\Container\ContainerInterface;
use Order\Form\Fieldset\ClusterCreateFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

class ClusterCreateFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new ClusterCreateFieldset(null, []);
        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new Cluster();
        $fieldset->setObject($prototype);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
