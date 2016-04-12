<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use Order\Form\Fieldset\LogicalConnectionFieldset;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');
        $physicalConnectionSourceFieldsetServiceName = $properServiceNameDetector->getPhysicalConnectionFieldsetServiceName();

        $realServiceLocator = $serviceLocator->getServiceLocator();
        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $connectionType = $requestAnalyzer->getConnectionType();
        $physicalConnectionTargetFieldsetServiceName = $isOrderRequest && strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0  ? $properServiceNameDetector->getPhysicalConnectionFieldsetServiceName() : null;

        $fieldset = new LogicalConnectionFieldset(null, [], $physicalConnectionSourceFieldsetServiceName, $physicalConnectionTargetFieldsetServiceName);
        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new LogicalConnection();
        $fieldset->setObject($prototype);
        
        return $fieldset;
    }

}
