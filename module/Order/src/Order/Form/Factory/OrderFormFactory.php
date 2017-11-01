<?php
namespace Order\Form\Factory;

use Interop\Container\ContainerInterface;
use Order\Form\OrderForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

class OrderFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $properServiceNameDetector = $container->get('Order\Utility\ProperServiceNameDetector');
        $fileTransferRequestFieldsetServiceName = $properServiceNameDetector->getFileTransferRequestFieldsetServiceName();
        $serviceInvoicePositionService = $container->get('Order\Service\ServiceInvoicePositionService');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $form = new OrderForm(
            null,
            [],
            $fileTransferRequestFieldsetServiceName,
            $serviceInvoicePositionService,
            $entityManager
        );
        $form->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
