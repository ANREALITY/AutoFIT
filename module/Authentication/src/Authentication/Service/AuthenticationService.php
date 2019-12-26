<?php
namespace Authentication\Authentication\Service;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

class AuthenticationService extends ZendAuthenticationService
{

    /**
     * Takes the passed identity and replaces the currently authenticated identity.
     *
     * @param array $identity
     */
    public function replaceAuthenticatedIdentity(array $identity)
    {
        $this->clearIdentity();
        $this->getStorage()->write($identity);
    }
    
}
