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
        $router = $serviceLocator->get('router');
        $request = $serviceLocator->get('request');
        $routerMatch = $router->match($request);

        $service = new FileTransferRequestMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new FileTransferRequest());

        $routerMathParamsForOrderForm = [
            'connectionType',
            'endpointSourceType',
            'endpointTargetType'
        ];
        $isOrderRequest = count(array_intersect($routerMathParamsForOrderForm, array_keys($routerMatch->getParams()))) ===
             count($routerMathParamsForOrderForm);

        if ($isOrderRequest) {
            $connectionType = $routerMatch->getParam('connectionType');
            $logicalConnectionMapperServiceName = 'Order\Mapper\LogicalConnection' . $connectionType . 'Mapper';

            $service->setLogicalConnectionMapper($serviceLocator->get($logicalConnectionMapperServiceName));
            $service->setUserMapper($serviceLocator->get('Order\Mapper\UserMapper'));
        }

        return $service;
    }

}