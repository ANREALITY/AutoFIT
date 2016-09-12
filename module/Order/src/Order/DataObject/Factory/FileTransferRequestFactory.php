<?php
namespace Order\DataObject\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\FileTransferRequest;

class FileTransferRequestFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $requestAnalyzer = $serviceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderEditRequest = $requestAnalyzer->isOrderEditRequest();
        $isOrderStatusChangingRequest = $requestAnalyzer->isOrderStatusChangingRequest();
        
        if ($isOrderEditRequest || $isOrderStatusChangingRequest) {
            $fileTransferRequestService = $serviceLocator->get('Order\Service\FileTransferRequestService');
            $router = $serviceLocator->get('router');
            $request = $serviceLocator->get('request');
            $routerMatch = $router->match($request);
            $routerMatchParams = $routerMatch->getParams();
            $paginator = $fileTransferRequestService->findAllWithBuldledData([], $routerMatchParams['id'], null, false);
            $fileTransferRequest = $paginator->getCurrentItems()[0];
        } else {
            $fileTransferRequest = new FileTransferRequest();
        }

        return $fileTransferRequest;
    }

}
