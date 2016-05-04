<?php
namespace Order\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

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
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $canCreateServiceWithName = false;
        $stringProcessor = $serviceLocator->get('Order\Utility\StringProcessor');

        if ($stringProcessor->endsWith($requestedName, self::NAME_PART_SERVICE) && class_exists($requestedName)) {
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
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $stringProcessor = $serviceLocator->get('Order\Utility\StringProcessor');

        $classNameService = str_replace(self::NAMESPACE_SERVICE . '\\', '', $requestedName);
        $prototypeClassName = $stringProcessor->strReplaceLast(self::NAME_PART_SERVICE, '', $classNameService);
        $classNameMapper = $prototypeClassName . self::NAME_PART_MAPPER;
        $mapperQualifiedClassName = self::NAMESPACE_MAPPER . '\\' . $classNameMapper;

        $service = new $requestedName($serviceLocator->get($mapperQualifiedClassName));

        return $service;
    }

}
