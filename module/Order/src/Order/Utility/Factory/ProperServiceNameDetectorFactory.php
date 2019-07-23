<?php
namespace Order\Utility\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Utility\ProperServiceNameDetector;
use Base\DataObject\FileTransferRequest;

class ProperServiceNameDetectorFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileTransferRequest = $container->get('Base\DataObject\FileTransferRequest');

        if (!$fileTransferRequest->getId()) {
            $router = $container->get('router');
            $request = $container->get('request');
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
