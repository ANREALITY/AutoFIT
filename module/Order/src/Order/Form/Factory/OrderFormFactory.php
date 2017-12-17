<?php
namespace Order\Form\Factory;

use Interop\Container\ContainerInterface;
use Order\Form\OrderForm;
use Order\Utility\ProperServiceNameDetector;
use Order\Utility\RequestAnalyzer;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

class OrderFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var RequestAnalyzer $requestAnalyzer */
        $requestAnalyzer = $container->get('Order\Utility\RequestAnalyzer');
        /** @var ProperServiceNameDetector $properServiceNameDetector */
        $properServiceNameDetector = $container->get('Order\Utility\ProperServiceNameDetector');
        $fileTransferRequestFieldsetServiceName = $properServiceNameDetector->getFileTransferRequestFieldsetServiceName();
        $serviceInvoicePositionService = $container->get('Order\Service\ServiceInvoicePositionService');
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $connectionType = $properServiceNameDetector->getConnectionType();
        $endpointSourceType = $properServiceNameDetector->getEndpointSourceType();
        $endpointTargetType = $properServiceNameDetector->getEndpointTargetType();

        $form = new OrderForm(
            null,
            [],
            $fileTransferRequestFieldsetServiceName,
            $serviceInvoicePositionService,
            $entityManager
        );
        $form
            ->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter())
        ;
        if ($requestAnalyzer->isRestoreRequest()) {
            $form
            ->setAttribute(
                'action',
                '/order/process/create' . '/' . $connectionType . '/' . $endpointSourceType . '/' . $endpointTargetType
            );
        }
        return $form;
    }

}
