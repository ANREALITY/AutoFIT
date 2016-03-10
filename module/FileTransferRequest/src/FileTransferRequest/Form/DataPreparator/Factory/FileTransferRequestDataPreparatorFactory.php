<?php
namespace FileTransferRequest\Form\DataPreparator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\DataObject\FileTransferRequest;
use FileTransferRequest\Form\DataPreparator\FileTransferRequestDataPreparator;
use DbSystel\DataObject\PhysicalConnectionCd;
use DbSystel\DataObject\EndpointCdTandem;
use DbSystel\DataObject\EndpointCdAs400;

class FileTransferRequestDataPreparatorFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $fileTransferRequestHydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\FileTransferRequestHydrator');
        $sourceEndpointHydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdAs400Hydrator');
        $targetEndpointHydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\EndpointCdTandemHydrator');
        $physicalConnectionHydrator = $serviceLocator->get('HydratorManager')->get('DbSystel\Hydrator\PhysicalConnectionCdHydrator');
        
        $dataPreparator = new FileTransferRequestDataPreparator(
            $fileTransferRequestHydrator, new FileTransferRequest(),
            $sourceEndpointHydrator, new EndpointCdAs400(),
            $targetEndpointHydrator, new EndpointCdTandem(),
            $physicalConnectionHydrator, new PhysicalConnectionCd()
        );
        return $dataPreparator;
    }
}
