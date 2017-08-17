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
    protected $id;

    /**
     *
     * @var string
     */
    protected $username;

    /**
     *
     * @var string
     */
    protected $role;

    /**
     *
     * @param integer $id
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