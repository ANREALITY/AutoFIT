<?php
namespace MasterData\Form\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;
use MasterData\Form\ClusterForm;

class ClusterFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new ClusterForm();
        $form->setAttribute('method', 'post')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
