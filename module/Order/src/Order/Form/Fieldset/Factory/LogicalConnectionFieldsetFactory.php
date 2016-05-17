<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\FactoryInterface;
use DbSystel\DataObject\LogicalConnection;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\Fieldset\LogicalConnectionCdFieldset;
use Order\Form\Fieldset\LogicalConnectionFtgwFieldset;

class LogicalConnectionFieldsetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $connectionType = $requestAnalyzer->getConnectionType();

        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');

        $physicalConnectionEndToEndFieldsetServiceName = $isOrderRequest &&
             strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0 ? $properServiceNameDetector->getPhysicalConnectionEndToEndFieldsetServiceName() : null;
        $physicalConnectionEndToMiddleFieldsetServiceName = $isOrderRequest &&
             strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0 ? $properServiceNameDetector->getphysicalConnectionEndToMiddleFieldsetServiceName() : null;
        $physicalConnectionMiddleToEndFieldsetServiceName = $isOrderRequest &&
             strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0 ? $properServiceNameDetector->getPhysicalConnectionMiddleToEndFieldsetServiceName() : null;

        if (strcasecmp($requestAnalyzer->getConnectionType(), LogicalConnection::TYPE_CD) === 0) {
            $fieldset = new LogicalConnectionCdFieldset(null, [], $physicalConnectionEndToEndFieldsetServiceName,
                $physicalConnectionEndToMiddleFieldsetServiceName, $physicalConnectionMiddleToEndFieldsetServiceName);
        } elseif (strcasecmp($requestAnalyzer->getConnectionType(), LogicalConnection::TYPE_FTGW) === 0) {
            $fieldset = new LogicalConnectionFtgwFieldset(null, [], $physicalConnectionEndToEndFieldsetServiceName,
                $physicalConnectionEndToMiddleFieldsetServiceName, $physicalConnectionMiddleToEndFieldsetServiceName);
        }

        $hydrator = $serviceLocator->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new LogicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
