<?php
namespace Order\Form\Fieldset\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Order\Form\Fieldset\FileTransferRequestCdFieldset;
use Order\Form\Fieldset\FileTransferRequestFtgwFieldset;
use Base\DataObject\FileTransferRequest;
use Interop\Container\ContainerInterface;
use Base\DataObject\LogicalConnection;

class FileTransferRequestFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $requestAnalyzer = $container->get('Order\Utility\RequestAnalyzer');
        $isOrderRequest = $requestAnalyzer->isOrderRequest();
        $properServiceNameDetector = $container->get('Order\Utility\ProperServiceNameDetector');
        $connectionType = $properServiceNameDetector->getConnectionType();

        if (strcasecmp($connectionType, LogicalConnection::TYPE_CD) === 0) {
            $fieldset = new FileTransferRequestCdFieldset();
        } elseif (strcasecmp($connectionType, LogicalConnection::TYPE_FTGW) === 0) {
            $fieldset = new FileTransferRequestFtgwFieldset();
        }

        $hydrator = $container
            ->get('HydratorManager')
            ->get('Zend\Hydrator\ClassMethods');
        $fieldset->setHydrator($hydrator);
        $prototype = new FileTransferRequest();
        $fieldset->setObject($prototype);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
