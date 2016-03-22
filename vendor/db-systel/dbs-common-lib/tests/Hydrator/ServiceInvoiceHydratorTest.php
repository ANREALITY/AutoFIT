<?php
namespace DbSystel\Hydrator;

use DbSystel\DataObject\ServiceInvoice;
use DbSystel\DataObject\Application;
use DbSystel\DataObject\Environment;

/**
 * ServiceInvoiceHydrator test case.
 */
class ServiceInvoiceHydratorTest extends AbstractHydratorTest
{

    const CHEXTURE = [
        'number' => 'BAR123',
        'application' => [
            'technical_short_name' => 'QWE123'
        ],
        'environment' => [
            'severity' => 30
        ]
    ];

    public function testHydrate()
    {
        $hydratedObject = $this->getHydrator()->hydrate($this->createFixtureArray(), new ServiceInvoice());
        
        $this->assertEquals(static::CHEXTURE['environment']['severity'], 
            $hydratedObject->getEnvironment()
                ->getSeverity());
    }

    protected function createHydrator()
    {
        $serviceManager = \Test\Bootstrap::getServiceManager();
        $hydratorManager = $serviceManager->get('HydratorManager');
        $hydrator = $hydratorManager->get('DbSystel\Hydrator\ServiceInvoiceHydrator');
        return $hydrator;
    }

    protected function createFixtureObject()
    {
        $serviceInvoice = new ServiceInvoice();
        $serviceInvoice->setNumber('BAR123');
        $application = new Application();
        $application->setTechnicalShortName('QWE123');
        $serviceInvoice->setApplication($application);
        $environment = new Environment();
        $environment->setSeverity(30);
        $serviceInvoice->setEnvironment($environment);
        return $serviceInvoice;
    }
}

