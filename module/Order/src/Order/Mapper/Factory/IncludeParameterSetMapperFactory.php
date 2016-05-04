<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\IncludeParameterSetMapper;
use DbSystel\DataObject\IncludeParameterSet;

class IncludeParameterSetMapperFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new IncludeParameterSetMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new IncludeParameterSet());

        $service->setIncludeParameterMapper($serviceLocator->get('Order\Mapper\IncludeParameterMapper'));

        return $service;
    }

}
