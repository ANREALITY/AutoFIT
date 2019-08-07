<?php
namespace Order\Service;

use Doctrine\ORM\Query;
use Order\Mapper\AbstractMapper;
use Order\Mapper\UserMapperInterface;
use Base\DataObject\User;

class UserService extends AbstractService implements UserServiceInterface
{

    /**
     * @var string
     */
    const DEFAULT_GUEST_USERNAME = 'asdf';

    /**
     * @var string
     */
    const DEFAULT_MEMBER_USERNAME = 'undefined';

    /**
     * @var string
     */
    const DEFAULT_POWER_USER_USERNAME = 'qwer';

    /**
     * @var string
     */
    const DEFAULT_ADMIN_USERNAME = 'undefined2';

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

    /**
     * {@inheritDoc}
     */
    public function findAllForAutocomplete(string $username = null)
    {
        return $this->mapper->findAll(
            [
                [
                    'username' => $username
                ]
            ],
            AbstractMapper::DEFAULT_QUERY_LIMIT,
            Query::HYDRATE_ARRAY
        );
    }

    /**
     *
     * {@inheritDoc}
     *
     */
    public function saveOne(User $user)
    {
        return $this->mapper->save($user);
    }

}
