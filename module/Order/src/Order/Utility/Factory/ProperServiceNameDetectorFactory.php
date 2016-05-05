<?php
namespace Order\Utility\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Utility\ProperServiceNameDetector;

class ProperServiceNameDetectorFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $router = $serviceLocator->get('router');
        $request = $serviceLocator->get('request');
        $routerMatch = $router->match($request);
        
        return new ProperServiceNameDetector($routerMatch->getParams());
    }

}
