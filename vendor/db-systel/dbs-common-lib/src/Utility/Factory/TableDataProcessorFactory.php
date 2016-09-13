<?php
namespace DbSystel\Utility\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DbSystel\Utility\TableDataProcessor;

class TableDataProcessorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TableDataProcessor(uniqid());
    }
}
