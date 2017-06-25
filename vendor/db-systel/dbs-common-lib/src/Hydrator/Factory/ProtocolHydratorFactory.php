<?php
namespace DbSystel\Hydrator\Factory;

use DbSystel\Hydrator\ProtocolHydrator;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ProtocolHydratorFactory implements FactoryInterface
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
        $protocolHydrator = new ProtocolHydrator();

        // no strategies

        // no naming map

        return $protocolHydrator;
    }

}
