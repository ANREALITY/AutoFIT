<?php
namespace Authorization;

use Zend\EventManager\EventInterface;
use Authorization\Acl\Acl;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\Http\Request as HttpRequest;
use Zend\Console\Request as ConsoleRequest;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../../data/cache' . '/' . 'autoload_classmap.application.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ]
            ]
        ];
    }

    public function onBootstrap(EventInterface $event)
    {
        $application = $event->getApplication();
        $eventManager = $application->getEventManager();
        $eventManager->attach('route', [
            $this,
            'onRoute'
        ], - 100);
    }

    public function onRoute(EventInterface $event)
    {
        if ($event->getRequest() instanceof HttpRequest) {
            $application = $event->getApplication();
            $routeMatch = $event->getRouteMatch();
            $serviceManager = $application->getServiceManager();
            $auth = $serviceManager->get('AuthenticationService');
            $acl = $serviceManager->get('Acl');
            $role = Acl::DEFAULT_ROLE;
            if ($auth->hasIdentity()) {
                $user = $auth->getIdentity();
                $role = $user['role'];
            }
            $controller = $routeMatch->getParam('controller');
            $action = $routeMatch->getParam('action');
            if (! $acl->hasResource($controller)) {
                throw new \Exception('Resource ' . $controller . ' not defined');
            }
            if (! $acl->isAllowed($role, $controller, $action)) {
                $response = $event->getResponse();
                $config = $serviceManager->get('config');
                $redirectRoute = ! empty($config['acl']['redirect_route']) ? $config['acl']['redirect_route'] : null;
                if (! empty($redirectRoute)) {
                    $url = $event->getRouter()->assemble($redirectRoute['params'], $redirectRoute['options']);
                    $response->getHeaders()->addHeaderLine('Location', $url);
                    $response->setStatusCode(Response::STATUS_CODE_403);
                    $response->sendHeaders();
                    exit();
                } else {
                    // simple variant
                    // $response->setContent(
                    // '<html><head><title>403 Forbidden</title></head><body><h1>403 Forbidden</h1></body></html>');
                    // more refined variant
                    $response->setStatusCode(Response::STATUS_CODE_403);
                    $event->getViewModel()->setTemplate('error/403');
                    return false;
                }
            }
        } elseif ($event->getRequest() instanceof ConsoleRequest) {
            // Do nothing and let the console script, e.g. ZFTool, do its job.
        }
    }

}
