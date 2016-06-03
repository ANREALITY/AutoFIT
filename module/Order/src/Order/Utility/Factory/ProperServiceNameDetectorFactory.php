<?php
namespace Order\Utility\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Utility\ProperServiceNameDetector;
use DbSystel\DataObject\FileTransferRequest;

class ProperServiceNameDetectorFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fileTransferRequest = $serviceLocator->get('DbSystel\DataObject\FileTransferRequest');

        if (!$fileTransferRequest->getId()) {
            $router = $serviceLocator->get('router');
            $request = $serviceLocator->get('request');
            $routerMatch = $router->match($request);
            $params = $routerMatch->getParams();
        } else {
            /**
             * @var FileTransferRequest $fileTransferRequest
             */
            $params = [];
            $logicalConnection = $fileTransferRequest->getLogicalConnection();
            $params['connectionType'] = $logicalConnection->getType();
            if ($logicalConnection->getPhysicalConnectionEndToEnd()) {
                $params['endpointSourceType'] = $logicalConnection->getPhysicalConnectionEndToEnd()->getEndpointSource()->getType();
                $params['endpointTargetType'] = $logicalConnection->getPhysicalConnectionEndToEnd()->getEndpointTarget()->getType();
            } else {
                $params['endpointSourceType'] = $logicalConnection->getPhysicalConnectionEndToMiddle()->getEndpointSource()->getType();
                $params['endpointTargetType'] = $logicalConnection->getPhysicalConnectionMiddleToEnd()->getEndpointTarget()->getType();
            }
        }

        return new ProperServiceNameDetector($params);
    }

}
