<?php
namespace Order\DataObject\Factory;

use DbSystel\Paginator\Paginator;
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
            $fileTransferRequestsRetrievingResult = $fileTransferRequestService->findAllWithBuldledData([], $routerMatchParams['id'], null, false);
            if (is_object($fileTransferRequestsRetrievingResult) && $fileTransferRequestsRetrievingResult instanceof Paginator) {
                $fileTransferRequest = $fileTransferRequestsRetrievingResult->getCurrentItems()[0];
            } elseif (is_array($fileTransferRequestsRetrievingResult)) {
                $fileTransferRequest = $fileTransferRequestsRetrievingResult[0];
            } else {
                $fileTransferRequest = null;
            }

        } else {
            $fileTransferRequest = new FileTransferRequest();
        }

        return $fileTransferRequest;
    }

}
