<?php
namespace Authentication\Service;

use Exception;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Session\SessionManager;
use Authentication\Adapter\DbTable as DbTableAuthenticationAdapter;

/**
 * The AuthManager service is responsible for user's login/logout and simple access filtering.
 * The access filtering feature checks whether the current visitor
 * is allowed to see the given page or not.  
 */
class AuthManager
{

    /** @var AuthenticationService */
    private $authenticationService;
    /** @var SessionManager */
    private $sessionManager;
    /**
     * Contents of the 'access_filter' config key.
     * @var array 
     */
    private $config;

    /**
     * AuthManager constructor.
     *
     * @param AuthenticationService $authService
     * @param SessionManager $sessionManager
     * @param array $config
     */
    public function __construct(AuthenticationService $authService, SessionManager $sessionManager, array $config)
    {
        $this->authenticationService = $authService;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }

    /**
     * Performs a login attempt.
     *
     * @param string $username
     * @return Result
     * @throws Exception
     */
    public function login(string $username)
    {   
        // Check if user has already logged in. If so, do not allow to log in twice.
        if ($this->authenticationService->getIdentity() != null) {
            throw new Exception('Already logged in');
        }
            
        // Authenticate with login/password.
        /** @var DbTableAuthenticationAdapter $authenticationAdapter */
        $authenticationAdapter = $this->authenticationService->getAdapter();
        $authenticationAdapter->setUsername($username);
        $result = $this->authenticationService->authenticate();
        
        return $result;
    }

    /**
     * This is a simple access control filter.
     * It is able to restrict unauthorized users to visit certain pages.
     * This method uses the 'access_filter' key in the config file
     * and determines, whether the current visitor is allowed to access the given controller action or not.
     * It returns true if allowed; otherwise false.
     *
     * @param string $controllerName
     * @param string $actionName
     * @return bool
     * @throws Exception
     */
    public function filterAccess(string $controllerName, string $actionName)
    {
        // Determine mode - 'restrictive' (default) or 'permissive'.
        // In restrictive mode all controller actions must be explicitly listed under the 'access_filter' config key,
        // and access is denied to any not listed action for unauthorized users.
        // In permissive mode, if an action is not listed under the 'access_filter' key, 
        // access to it is permitted to anyone (even for not logged in users.
        // Restrictive mode is more secure and recommended to use.
        $mode = isset($this->config['options']['mode']) ? $this->config['options']['mode'] : 'restrictive';
        if ($mode != 'restrictive' && $mode != 'permissive') {
            throw new Exception('Invalid access filter mode (expected either restrictive or permissive mode');
        }
        if (isset($this->config['controllers'][$controllerName])) {
            $items = $this->config['controllers'][$controllerName];
            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];
                if (is_array($actionList) && in_array($actionName, $actionList) || $actionList == '*') {
                    if ($allow == '*') {
                        return true; // Anyone is allowed to see the page.
                    } else if ($allow == '@' && $this->authenticationService->hasIdentity()) {
                        return true; // Only authenticated user is allowed to see the page.
                    } else {                    
                        return false; // Access denied.
                    }
                }
            }            
        }
        // In restrictive mode, we forbid access for unauthorized users to any 
        // action not listed under 'access_filter' key (for security reasons).
        if ($mode == 'restrictive' && ! $this->authenticationService->hasIdentity()) {
            return false;
        }
        // Permit access to this page.
        return true;
    }

}
