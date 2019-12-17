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

    /**
     * {@inheritDoc}
     *
     * The current implementation is "stupid" and only consider the case,
     * that a user can only have one related user and their names follow the schema "xyz" and "xyz2".
     * For now it's sufficient, but it would be nice to implement this logic a more flexible and clean way,
     * so that all related user can be retrieved (and not only one) and no string manipulation would be needed.
     * @todo Introduce users/identities groups and implement this method a more flexible and clean way.
     */
    public function findRelatedUser(string $username)
    {
        $adminUserSuffix = '2';
        $relatedUsername = null;
        if (substr($username, -1) === $adminUserSuffix) {
            $relatedUsername = substr($username, 0, -1);
        } else {
            $relatedUsername = $username . $adminUserSuffix;
        }
        $relatedUser = $this->mapper->findOneByUsername($relatedUsername);
        return $relatedUser;
    }

}
