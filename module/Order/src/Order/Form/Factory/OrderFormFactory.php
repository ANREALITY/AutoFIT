<?php
namespace Order\Form\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Form\OrderForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class OrderFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $properServiceNameDetector = $serviceLocator->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');
        $fileTransferRequestFieldsetServiceName = $properServiceNameDetector->getFileTransferRequestFieldsetServiceName();
        $dbAdapter = $dbAdapter = $serviceLocator->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $serviceInvoicePositionService = $serviceLocator->getServiceLocator()->get('Order\Service\ServiceInvoicePositionService');

        $form = new OrderForm(
            null,
            [],
            $fileTransferRequestFieldsetServiceName,
            $dbAdapter,
            $serviceInvoicePositionService
        );
        $form->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
