<?php
namespace Order\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Form\OrderForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class OrderFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $properServiceNameDetector = $container->getServiceLocator()->get(
            'Order\Utility\ProperServiceNameDetector');
        $fileTransferRequestFieldsetServiceName = $properServiceNameDetector->getFileTransferRequestFieldsetServiceName();
        $dbAdapter = $dbAdapter = $container->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $serviceInvoicePositionService = $container->getServiceLocator()->get('Order\Service\ServiceInvoicePositionService');

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
