<?php
namespace Order\Mapper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Mapper\FileParameterSetMapper;
use DbSystel\DataObject\FileParameterSet;

class FileParameterSetMapperFactory implements FactoryInterface
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
        $service = new FileParameterSetMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new FileParameterSet());

        $service->setFileParameterMapper($serviceLocator->get('Order\Mapper\FileParameterMapper'));
        $service->setArrayProcessor($serviceLocator->get('DbSystel\Utility\ArrayProcessor'));

        return $service;
    }

}
