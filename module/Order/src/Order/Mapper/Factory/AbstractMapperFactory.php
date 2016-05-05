<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractMapperFactory implements AbstractFactoryInterface
{

    /**
     *
     * @var string
     */
    const NAME_PART_MAPPER = 'Mapper';

    /**
     *
     * @var string
     */
    const NAMESPACE_MAPPER = 'Order\Mapper';

    /**
     *
     * @var string
     */
    const NAMESPACE_PROTOTYPE = 'DbSystel\DataObject';

    /**
     *
     * {@inheritDoc}
     *
     * @see AbstractFactoryInterface::canCreateServiceWithName()
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $canCreateServiceWithName = false;

        $matches = [];
        $pattern = '[a-zA-z0-9]+' . self::NAME_PART_MAPPER . '$';
        preg_match('/' . $pattern . '/', $requestedName, $matches);

        if (! empty($matches[0]) && $matches[0] === $requestedName && class_exists($requestedName)) {
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
        $mapperClassName = str_replace(self::NAMESPACE_MAPPER . '\\', '', $requestedName);
        $prototypeClassName = str_replace(self::NAME_PART_MAPPER, '', $mapperClassName);
        $prototypeQualifiedClassName = self::NAMESPACE_PROTOTYPE . '\\' . $prototypeClassName;

        $service = new $requestedName($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new $prototypeQualifiedClassName());

        return $service;
    }

}
