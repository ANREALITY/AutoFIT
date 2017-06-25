<?php
namespace DbSystel\Hydrator\Factory;

use DbSystel\DataObject\Protocol;
use DbSystel\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use DbSystel\Hydrator\Strategy\Entity\GenericEntityStrategy;
use Interop\Container\ContainerInterface;
use Zend\Hydrator\HydratorPluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtocolSetHydratorFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $rotocolSetHydrator = $container->get(HydratorPluginManager::class)->get('Zend\Hydrator\ClassMethods');
        $protocolHydrator = $container->get('DbSystel\Hydrator\ProtocolHydrator');

        $rotocolSetHydrator->addStrategy('protocols', new GenericCollectionStrategy($protocolHydrator, new Protocol()));

        // no naming map
        
        return $rotocolSetHydrator;
    }

}
