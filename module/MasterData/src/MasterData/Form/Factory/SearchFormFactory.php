<?php
namespace MasterData\Form\Factory;

use Interop\Container\ContainerInterface;
use MasterData\Form\SearchForm;
use Zend\Hydrator\ClassMethods;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\Factory\FactoryInterface;

class SearchFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new SearchForm('search');
        $form->setAttribute('method', 'get')
            ->setHydrator(new ClassMethods())
            ->setInputFilter(new InputFilter());
        return $form;
    }

}
