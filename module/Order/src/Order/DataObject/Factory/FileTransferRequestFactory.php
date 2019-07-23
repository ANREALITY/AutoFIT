<?php
namespace Order\DataObject\Factory;

use Base\Paginator\Paginator;
use Order\Service\FileTransferRequestServiceInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Base\DataObject\FileTransferRequest;

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
            /** @var FileTransferRequestServiceInterface $fileTransferRequestService */
            $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');
            $router = $container->get('router');
            $request = $container->get('request');
            $routerMatch = $router->match($request);
            $routerMatchParams = $routerMatch->getParams();
            $fileTransferRequest = $fileTransferRequestService->findOne($routerMatchParams['id']);

        } else {
            $fileTransferRequest = new FileTransferRequest();
        }

        return $fileTransferRequest;
    }

}
