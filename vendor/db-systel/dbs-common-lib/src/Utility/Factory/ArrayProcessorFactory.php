<?php
namespace DbSystel\Utility\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\Utility\ArrayProcessor;

class ArrayProcessorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ArrayProcessor(uniqid());
    }
}
