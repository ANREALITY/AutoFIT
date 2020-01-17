<?php
namespace Authentication\Adapter;

use Order\Service\UserServiceInterface;
use Zend\Authentication\Adapter\AbstractAdapter;

abstract class AbstractAuthenticationAdapter extends AbstractAdapter
{

    /** @var UserServiceInterface */
    protected $userService;
    /** @var string */
    protected $username;

    /**
     * @param UserServiceInterface $userService
     */
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

}
