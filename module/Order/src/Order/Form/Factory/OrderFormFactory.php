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
        $form = new OrderForm();
        $form->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }
}
