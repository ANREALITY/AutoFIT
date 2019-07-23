<?php
namespace Authentication\Adapter;

use Authorization\Acl\Acl;
use Order\Service\UserServiceInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Base\DataObject\User;

class DbTable extends AbstractAdapter
{

    /**
     *
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     *
     * @var string
     */
    protected $username;

    public function __construct(UserServiceInterface $userService, string $username)
    {
        $this->userService = $userService;
        $this->username = $username;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see AdapterInterface::authenticate()
     */
    public function authenticate()
    {
        $user = $this->userService->findOneByUsername($this->username);
        if (! $user) {
            $user = new User();
            $user->setRole(Acl::DEFAULT_ROLE);
            $user->setUsername($this->username);
            $user = $this->userService->saveOne($user);
        }
        $identity = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'role' => $user->getRole()
        ];
        $this->setIdentity($identity);
        $authResult = new Result(Result::SUCCESS, $identity);
        return $authResult;
    }

}
