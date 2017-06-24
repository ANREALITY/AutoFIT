<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use DbSystel\DataObject\LogicalConnection;
use Interop\Container\ContainerInterface;
use Order\Form\Fieldset\LogicalConnectionCdFieldset;
use Order\Form\Fieldset\LogicalConnectionFtgwFieldset;

class LogicalConnectionFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();
        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $isOrderEditRequest = $requestAnalyzer->isOrderEditRequest();
        $properServiceNameDetector = $realServiceLocator->get('Order\Utility\ProperServiceNameDetector');
        $connectionType = $properServiceNameDetector->getConnectionType();

        $physicalConnectionEndToEndFieldsetServiceName = ($isOrderRequest || $isOrderEditRequest) &&
             strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0 ? $properServiceNameDetector->getPhysicalConnectionEndToEndFieldsetServiceName() : null;
        $physicalConnectionEndToMiddleFieldsetServiceName = ($isOrderRequest || $isOrderEditRequest) &&
             strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0 ? $properServiceNameDetector->getphysicalConnectionEndToMiddleFieldsetServiceName() : null;
        $physicalConnectionMiddleToEndFieldsetServiceName = ($isOrderRequest || $isOrderEditRequest) &&
             strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0 ? $properServiceNameDetector->getPhysicalConnectionMiddleToEndFieldsetServiceName() : null;

        if (strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0) {
            $fieldset = new LogicalConnectionCdFieldset(null, [], $physicalConnectionEndToEndFieldsetServiceName,
                $physicalConnectionEndToMiddleFieldsetServiceName, $physicalConnectionMiddleToEndFieldsetServiceName);
        } elseif (strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            $fieldset = new LogicalConnectionFtgwFieldset(null, [], $physicalConnectionEndToEndFieldsetServiceName,
                $physicalConnectionEndToMiddleFieldsetServiceName, $physicalConnectionMiddleToEndFieldsetServiceName);
        }

        $hydrator = $container->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new LogicalConnection();
        $fieldset->setObject($prototype);

        return $fieldset;
    }

}
