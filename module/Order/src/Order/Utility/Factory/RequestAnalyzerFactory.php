<?php
namespace Order\Utility\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Order\Utility\RequestAnalyzer;

class RequestAnalyzerFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see FactoryInterface::createService()
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $router = $container->get('router');
        $request = $container->get('request');
        $routerMatch = $router->match($request);

        $routerMatchParams = $routerMatch->getParams();
        $requestQuery = $request->getQuery()->toArray();
        $requestPost = $request->getPost();

        $config = $container->get('Config');
        $orderStatusChangingActions = isset($config['status']['order']['per_operation'])
            ? array_keys($config['status']['order']['per_operation']) : [];

        return new RequestAnalyzer($routerMatchParams, $requestQuery, $requestPost->toArray(),
            'Order\Controller\Process', 'edit', $orderStatusChangingActions);
    }

}
