<?php
namespace DbSystel\Hydrator\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;

class UserHydratorFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator            
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userHydrator = $serviceLocator->get('Zend\Hydrator\ClassMethods');

        // no strategies

        $nameMapping = array(
            'ms_exchange_name' => 'msExchangeName',
        );
        $namingStrategy = new MapNamingStrategy($nameMapping);
        $userHydrator->setNamingStrategy($namingStrategy);

        return $userHydrator;
    }
}
