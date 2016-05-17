<?php
namespace DbSystel\DataObject;

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
     * @var int
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
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return the $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     *
     * @return the $role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     *
     * @param boolean $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

}