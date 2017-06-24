<?php
namespace AuditLogging\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use AuditLogging\Form\AuditLogForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;

class AuditLogFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new AuditLogForm('audit_log');
        $form->setAttribute('method', 'get')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
