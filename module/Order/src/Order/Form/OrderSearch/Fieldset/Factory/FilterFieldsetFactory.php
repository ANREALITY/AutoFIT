<?php
namespace Order\Form\OrderSearch\Fieldset\Factory;

use Interop\Container\ContainerInterface;
use Order\Form\OrderSearch\Fieldset\FilterFieldset;
use Order\Form\OrderSearch\OrderSearchForm;
use Zend\Router\Http\RouteMatch;
use Zend\ServiceManager\Factory\FactoryInterface;

class FilterFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('AuthenticationService');
        $username = $authenticationService->getIdentity()['username'];
        /** @var RouteMatch $routeMatch */
        $routeMatch = $container->get('Application')->getMvcEvent()->getRouteMatch();
        $searchType = $routeMatch->getMatchedRouteName() === 'order/list-own'
            ? OrderSearchForm::SEARCH_TYPE_OWN : OrderSearchForm::SEARCH_TYPE_ALL
        ;

        $fieldset = new FilterFieldset(null, [], $username, $searchType);

        return $fieldset;
    }

}
