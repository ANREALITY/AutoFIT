<?php
namespace DbSystel\DataObject;

class AccessConfig extends AbstractDataObject
{

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
     * @var bool
     */
    protected $permissionRead;

    /**
     *
     * @var bool
     */
    protected $permissionWrite;

    /**
     *
     * @var bool
     */
    protected $permissionDelete;

    /**
     *
     * @var AccessConfigSet
     */
    protected $accessConfigSet;

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
     * @param boolean $permissionRead
     */
    public function setPermissionRead($permissionRead)
    {
        $this->permissionRead = $permissionRead;

        return $this;
    }

    /**
     * @return bool $permissionRead
     */
    public function getPermissionRead()
    {
        return $this->permissionRead;
    }

    /**
     * @param boolean $permissionWrite
     */
    public function setPermissionWrite($permissionWrite)
    {
        $this->permissionWrite = $permissionWrite;

        return $this;
    }

    /**
     * @return bool $permissionWrite
     */
    public function getPermissionWrite()
    {
        return $this->permissionWrite;
    }

    /**
     * @param boolean $permissionDelete
     */
    public function setPermissionDelete($permissionDelete)
    {
        $this->permissionDelete = $permissionDelete;

        return $this;
    }

    /**
     * @return bool $permissionDelete
     */
    public function getPermissionDelete()
    {
        return $this->permissionDelete;
    }

    /**
     *
     * @param AccessConfigSet $accessConfigSet
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     *
     * @return AccessConfigSet $accessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

}
