<?php
namespace Order\Mapper\Factory;

use Order\Mapper\FileTransferRequestMapper;
use DbSystel\DataObject\FileTransferRequest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileTransferRequestMapperFactory implements FactoryInterface
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
        $service = new FileTransferRequestMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new FileTransferRequest());

        $requestAnalyzer = $serviceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();

        $service->setLogicalConnectionMapper($serviceLocator->get('Order\Mapper\LogicalConnectionMapper'));
        $service->setUserMapper($serviceLocator->get('Order\Mapper\UserMapper'));

        return $service;
    }

}