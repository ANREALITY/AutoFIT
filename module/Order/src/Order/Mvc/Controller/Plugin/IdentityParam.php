<?php
namespace Order\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;

class IdentityParam extends AbstractPlugin
{

    /**
     *
     * @var AuthenticationService
     */
    protected $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke(string $paramKey)
    {
        $identity = $this->authenticationService->hasIdentity() ? $this->authenticationService->getIdentity() : [];
        $paramValue = isset($identity[$paramKey]) ? $identity[$paramKey] : null;
        return $paramValue;
    }

}