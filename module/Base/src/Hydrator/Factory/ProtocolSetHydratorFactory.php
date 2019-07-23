<?php
namespace Base\Hydrator\Factory;

use Base\DataObject\Protocol;
use Base\Hydrator\Strategy\Entity\GenericCollectionStrategy;
use Base\Hydrator\Strategy\Entity\GenericEntityStrategy;
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
        $protocolHydrator = $container->get(HydratorPluginManager::class)->get('Base\Hydrator\ProtocolHydrator');

        $rotocolSetHydrator->addStrategy('protocols', new GenericCollectionStrategy($protocolHydrator, new Protocol()));

        // no naming map
        
        return $rotocolSetHydrator;
    }

}
