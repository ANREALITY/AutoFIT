<?php
namespace Order\Form\Fieldset\Factory;

use DbSystel\DataObject\Cluster;
use Interop\Container\ContainerInterface;
use Order\Form\Fieldset\ClusterFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

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
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
