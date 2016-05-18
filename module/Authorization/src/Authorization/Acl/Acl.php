<?php
namespace Authorization\Acl;

use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Authorization\Acl\Resource\ParametrizedResource as Resource;

class Acl extends ZendAcl
{

    /**
     * Role "member"
     */
    const ROLE_MEMBER = 'member';

    /**
     * Role "admin"
     */
    const ROLE_ADMIN = 'admin';

    /**
     * Default Role
     */
    const DEFAULT_ROLE = self::ROLE_MEMBER;

    protected $assertions;

    protected $routeMatchParams;

    /**
     * Constructor
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    public function __construct(array $config, array $assertions = [], array $routeMatchParams = [])
    {
        if (! isset($config['acl']['roles']) || ! isset($config['acl']['resources'])) {
            throw new \Exception('Invalid ACL config found');
        }

        $roles = $config['acl']['roles'];
        if (! isset($roles[self::DEFAULT_ROLE])) {
            $roles[self::DEFAULT_ROLE] = '';
        }

        $this->assertions = $assertions;
        $this->routeMatchParams = $routeMatchParams;

        $this->addRoles($roles)->addResources($config['acl']['resources']);
    }

    /**
     * Adds roles to ACL
     *
     * @param array $roles
     * @return Acl
     */
    protected function addRoles(array $roles)
    {
        foreach ($roles as $name => $parent) {
            if (! $this->hasRole($name)) {
                if (empty($parent)) {
                    $parent = [];
                } else {
                    $parent = explode(',', $parent);
                }

                $this->addRole(new Role($name), $parent);
            }
        }

        return $this;
    }

    /**
     * Adds resources to ACL
     *
     * @param
     *            $resources
     * @return Acl
     * @throws \Exception
     */
    protected function addResources(array $resources)
    {
        foreach ($resources as $permission => $controllers) {
            foreach ($controllers as $controller => $actions) {
                if ($controller == 'all') {
                    $controller = null;
                } else {
                    if (! $this->hasResource($controller)) {
                        $this->addResource(new Resource($controller, $this->routeMatchParams));
                    }
                }
                foreach ($actions as $action => $roleConfig) {
                    if (is_array($roleConfig)) {
                        foreach ($roleConfig as $role => $assertion) {
                            if ($action == 'all') {
                                $action = null;
                            }
                            $assertion = !empty($this->assertions[$assertion]) ? $this->assertions[$assertion] : null;
                            if ($permission == 'allow') {
                                $this->allow($role, $controller, $action, $assertion);
                            } elseif ($permission == 'deny') {
                                $this->deny($role, $controller, $action, $assertion);
                            } else {
                                throw new \Exception('No valid permission defined: ' . $permission);
                            }
                        }
                    } elseif (is_string($roleConfig)) {
                        if ($action == 'all') {
                            $action = null;
                        }
                        if ($permission == 'allow') {
                            $this->allow($roleConfig, $controller, $action);
                        } elseif ($permission == 'deny') {
                            $this->deny($roleConfig, $controller, $action);
                        } else {
                            throw new \Exception('No valid permission defined: ' . $permission);
                        }
                    }
                }
            }
        }

        return $this;
    }

}
