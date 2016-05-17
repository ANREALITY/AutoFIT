<?php
namespace Order\Utility\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Order\Utility\RequestAnalyzer;

class RequestAnalyzerFactory implements FactoryInterface
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

        $routerMatchParams = $routerMatch->getParams();
        $requestQuery = $request->getQuery()->toArray();
        $requestPost = $request->getPost();

        return new RequestAnalyzer($routerMatchParams, $requestQuery, $requestPost->toArray());
    }

}
