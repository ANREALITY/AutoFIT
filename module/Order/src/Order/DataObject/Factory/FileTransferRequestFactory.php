<?php
namespace Order\DataObject\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\FileTransferRequest;

class FileTransferRequestFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $requestAnalyzer = $container->get('Order\Utility\RequestAnalyzer');
        $isOrderEditRequest = $requestAnalyzer->isOrderEditRequest();
        $isOrderStatusChangingRequest = $requestAnalyzer->isOrderStatusChangingRequest();
        
        if ($isOrderEditRequest || $isOrderStatusChangingRequest) {
            $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');
            $router = $container->get('router');
            $request = $container->get('request');
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
