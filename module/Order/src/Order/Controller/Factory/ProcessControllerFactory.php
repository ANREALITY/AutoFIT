<?php
namespace Order\Controller\Factory;

use Order\Controller\ProcessController;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\FileTransferRequest;

class ProcessControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {


        $requestAnalyzer = $container->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $isOrderEditRequest = $requestAnalyzer->isOrderEditRequest();
        $isStartRequest = $requestAnalyzer->isStartRequest();
        $properServiceNameDetector = $container->get('Order\Utility\ProperServiceNameDetector');
        $connectionType = $properServiceNameDetector->getConnectionType();
        $endpointSourceType = $properServiceNameDetector->getEndpointSourceType();
        $endpointTargetType = $properServiceNameDetector->getEndpointTargetType();
        $dataExporter = $container->get('DbSystel\DataExport\DataExporter');

        $fileTransferRequestService = $container->get('Order\Service\FileTransferRequestService');
        $fileTransferRequest = $container->get('DbSystel\DataObject\FileTransferRequest');
        $service = new ProcessController($fileTransferRequest, $fileTransferRequestService);

        if ($isOrderRequest || $isOrderEditRequest) {
            $formElementManager = $container->get('FormElementManager');
            $orderForm = $formElementManager->get('Order\Form\OrderForm');
            $service->setOrderForm($orderForm);
            $service->setConnectionType($connectionType);
            $service->setEndpointSourceType($endpointSourceType);
            $service->setEndpointTargetType($endpointTargetType);
        } elseif ($isStartRequest) {
            $service->setConnectionType($connectionType);
        } else {
            $service->setDataExporter($dataExporter);
            $config = $container->get('Config');
            $exportFolder = $config['export']['folder'];
            $service->setExportFolder($exportFolder);
            $formElementManager = $container->get('FormElementManager');
            $orderSearchForm = $formElementManager->get('Order\Form\OrderSearchForm');
            $service->setOrderSearchForm($orderSearchForm);
        }

        return $service;
    }

}
