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
        $properServiceNameDetector = $container->get(
            'Order\Utility\ProperServiceNameDetector');
        $fileTransferRequestFieldsetServiceName = $properServiceNameDetector->getFileTransferRequestFieldsetServiceName();
        $dbAdapter = $dbAdapter = $container->get('Zend\Db\Adapter\Adapter');
        $serviceInvoicePositionService = $container->get('Order\Service\ServiceInvoicePositionService');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $form = new OrderForm(
            null,
            [],
            $fileTransferRequestFieldsetServiceName,
            $dbAdapter,
            $serviceInvoicePositionService,
            $entityManager
        );
        $form->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
