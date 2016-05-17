<?php
namespace Order\Service;

use Order\Mapper\UserMapperInterface;
use DbSystel\DataObject\User;

class UserService extends AbstractService implements UserServiceInterface
{

    /**
     *
     * @var UserMapperInterface
     */
    protected $mapper;

    /**
     *
     * @param UserMapperInterface $mapper
     */
    public function __construct(UserMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @return User
     * @see UserServiceInterface::findOneByUsername()
     */
    public function findOneByUsername(string $username)
    {
        return $this->mapper->findOneByUsername($username);
    }

}
