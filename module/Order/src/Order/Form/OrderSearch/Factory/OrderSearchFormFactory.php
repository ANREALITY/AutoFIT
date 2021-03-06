<?php
namespace Order\Form\OrderSearch\Factory;

use Interop\Container\ContainerInterface;
use Order\Form\OrderSearch\OrderSearchForm;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

class OrderSearchFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new OrderSearchForm('order_search');
        $form->setAttribute('method', 'get')
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
