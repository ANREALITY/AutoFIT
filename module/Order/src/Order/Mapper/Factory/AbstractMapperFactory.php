<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractMapperFactory implements AbstractFactoryInterface
{

    protected $classNamePartMapper = 'Mapper';

    protected $namespaceMapper = 'Order\Mapper';

    protected $namespacePrototype = 'DbSystel\DataObject';

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

        if ($stringProcessor->endsWith($requestedName, $this->classNamePartMapper) && class_exists($requestedName)) {
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
        $classNameMapper = str_replace($this->namespaceMapper . '\\', '', $requestedName);
        $prototypeClassName = str_replace($this->classNamePartMapper, '', $classNameMapper);
        $prototypeQualifiedClassName = $this->namespacePrototype . '\\' . $prototypeClassName;

        $service = new $requestedName($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'),
            new $prototypeQualifiedClassName());

        return $service;
    }

}
