<?php
namespace Authentication\Adapter;

use Order\Service\UserServiceInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;

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
        $identity = [
            'id' => null,
            'username' => $this->username,
            'role' => 'member'
        ];
        try {
            $user = $this->userService->findOneByUsername($this->username);
            $identity['id'] = $user->getId();
            $identity['role'] = $user->getAdmin() ? 'admin': 'member'
            ;
        } catch (\InvalidArgumentException $e) {}
        $this->setIdentity($identity);
        $authResult = new Result(Result::SUCCESS, $identity);
        return $authResult;
    }

}
