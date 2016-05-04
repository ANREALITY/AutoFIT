<?php
namespace Order\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class AbstractServiceFactory implements AbstractFactoryInterface
{

    protected $classNamePartService = 'Service';

    protected $classNamePartMapper = 'Mapper';

    protected $namespaceService = 'Order\Service';

    protected $namespaceMapper = 'Order\Mapper';

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

        if ($stringProcessor->endsWith($requestedName, $this->classNamePartService) && class_exists($requestedName)) {
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

        $classNameService = str_replace($this->namespaceService . '\\', '', $requestedName);
        $prototypeClassName = $stringProcessor->strReplaceLast($this->classNamePartService, '', $classNameService);
        $classNameMapper = $prototypeClassName . $this->classNamePartMapper;
        $mapperQualifiedClassName = $this->namespaceMapper . '\\' . $classNameMapper;

        $service = new $requestedName($serviceLocator->get($mapperQualifiedClassName));

        return $service;
    }

}
