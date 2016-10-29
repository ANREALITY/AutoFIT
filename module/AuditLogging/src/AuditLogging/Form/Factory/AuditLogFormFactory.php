<?php
namespace AuditLogging\Form\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AuditLogging\Form\AuditLogForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class AuditLogFormFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new AuditLogForm('audit_log');
        $form->setAttribute('method', 'get')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
