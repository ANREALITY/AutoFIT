<?php
namespace Authentication\Adapter;

use Authorization\Acl\Acl;
use Order\Service\UserService;
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

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * In this naïve implementation we simply reply on the data received from the user.
     * The logic is:
     * If the user asserts to be Foo, the user is Foo.
     * We are using this this approach only as a temporary intermediate step to an SSO&OAuth driven implementation.
     * @todo Extend this behavior, when switching to SSO.
     *
     * {@inheritDoc}
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
