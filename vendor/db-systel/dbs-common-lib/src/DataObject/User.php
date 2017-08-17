<?php
namespace DbSystel\DataObject;

/**
 * Class User
 *
 * @package DbSystel\DataObject
 */
class User extends AbstractDataObject
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
     *
     * @var integer
     */
    private $id;

    /**
     *
     * @var string
     */
    private $username;

    /**
     *
     * @var string
     */
    private $role;

    /**
     *
     * @param integer $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param boolean $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     *
     * @return string $role
     */
    public function getRole()
    {
        return $this->role;
    }

}