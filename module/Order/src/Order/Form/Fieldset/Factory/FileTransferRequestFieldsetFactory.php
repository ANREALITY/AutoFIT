<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestCdFieldset;
use Order\Form\Fieldset\FileTransferRequestFtgwFieldset;
use DbSystel\DataObject\FileTransferRequest;
use Interop\Container\ContainerInterface;
use DbSystel\DataObject\LogicalConnection;

class FileTransferRequestFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $realServiceLocator = $container->getServiceLocator();
        $requestAnalyzer = $realServiceLocator->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $properServiceNameDetector = $realServiceLocator->get('Order\Utility\ProperServiceNameDetector');
        $connectionType = $properServiceNameDetector->getConnectionType();

        if (strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0) {
            $fieldset = new FileTransferRequestCdFieldset();
        } elseif (strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            $fieldset = new FileTransferRequestFtgwFieldset();
        }

        $hydrator = $container->getServiceLocator()
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new FileTransferRequest();
        $fieldset->setObject($prototype);
        $dbAdapter = $realServiceLocator->get('Zend\Db\Adapter\Adapter');
        $fieldset->setDbAdapter($dbAdapter);

        return $fieldset;
    }

}
