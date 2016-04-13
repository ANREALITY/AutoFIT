<?php
namespace Order\Mapper\Factory;

use Order\Mapper\LogicalConnectionMapper;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionMapperFactory implements FactoryInterface
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
        $requestAnalyzer = $serviceLocator->get('Order\Utility\RequestAnalyzer');
        
        if (strcasecmp($requestAnalyzer->getConnectionType(), LogicalConnection::TYPE_CD) === 0) {
            $connectionType = LogicalConnection::TYPE_CD;
        } elseif (strcasecmp($requestAnalyzer->getConnectionType(), LogicalConnection::TYPE_FTGW) === 0) {
            $connectionType = LogicalConnection::TYPE_FTGW;
        }
        
        $service = new LogicalConnectionMapper($serviceLocator->get('Zend\Db\Adapter\Adapter'), 
            $serviceLocator->get('HydratorManager')->get('Zend\Hydrator\ClassMethods'), new LogicalConnection(), 
            $connectionType);
        
        $properServiceNameDetector = $serviceLocator->get('Order\Utility\ProperServiceNameDetector');
        $physicalConnectionMapperServiceName = $properServiceNameDetector->getPhysicalConnectionMapperServiceName();
        
        $service->setPhysicalConnectionMapper($serviceLocator->get($physicalConnectionMapperServiceName));
        
        return $service;
    }

}