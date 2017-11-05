<?php
namespace MasterData\Form\Fieldset\Factory;

use Interop\Container\ContainerInterface;
use MasterData\Form\Fieldset\FilterFieldset;
use Zend\ServiceManager\Factory\FactoryInterface;

class FilterFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fieldset = new FilterFieldset(null, []);
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fieldset->setEntityManager($entityManager);

        return $fieldset;
    }

}
