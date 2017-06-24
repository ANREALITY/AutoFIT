<?php
namespace Order\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class AbstractServiceFactory implements AbstractFactoryInterface
{

    /**
     *
     * @var string
     */
    const NAME_PART_SERVICE = 'Service';

    /**
     *
     * @var string
     */
    const NAME_PART_MAPPER = 'Mapper';

    /**
     *
     * @var string
     */
    const NAMESPACE_SERVICE = 'Order\Service';

    /**
     *
     * @var string
     */
    const NAMESPACE_MAPPER = 'Order\Mapper';

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractFactoryInterface::canCreateServiceWithName()
     */
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $canCreateServiceWithName = false;

        $matches = [];
        $pattern = '[a-zA-z0-9]+' . self::NAME_PART_SERVICE . '$';
        preg_match('/' . $pattern . '/', $requestedName, $matches);

        if (! empty($matches[0]) && $matches[0] === $requestedName &&
             strpos($requestedName, self::NAMESPACE_SERVICE) === 0 && class_exists($requestedName)) {
            $canCreateServiceWithName = true;
        }

        return $canCreateServiceWithName;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractFactoryInterface::createServiceWithName()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $serviceClassName = str_replace(self::NAMESPACE_SERVICE . '\\', '', $requestedName);
        $prototypeClassName = preg_replace('/' . self::NAME_PART_SERVICE . '$/', '', $serviceClassName);
        $mapperClassName = $prototypeClassName . self::NAME_PART_MAPPER;
        $mapperQualifiedClassName = self::NAMESPACE_MAPPER . '\\' . $mapperClassName;

        $service = new $requestedName($container->get($mapperQualifiedClassName));

        return $service;
    }

}
