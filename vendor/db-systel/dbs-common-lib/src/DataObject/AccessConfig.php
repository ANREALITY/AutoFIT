<?php
namespace DbSystel\DataObject;

class AccessConfig extends AbstractDataObject
{

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
     * @return the $permissionRead
     */
    public function getPermissionRead()
    {
        return $this->permissionRead;
    }


    /**
     * @param boolean $permissionRead
     */
    public function setPermissionRead($permissionRead)
    {
        $this->permissionRead = $permissionRead;
    }


    /**
     * @return the $permissionWrite
     */
    public function getPermissionWrite()
    {
        return $this->permissionWrite;
    }


    /**
     * @param boolean $permissionWrite
     */
    public function setPermissionWrite($permissionWrite)
    {
        $this->permissionWrite = $permissionWrite;
    }


    /**
     * @return the $permissionDelete
     */
    public function getPermissionDelete()
    {
        return $this->permissionDelete;
    }


    /**
     * @param boolean $permissionDelete
     */
    public function setPermissionDelete($permissionDelete)
    {
        $this->permissionDelete = $permissionDelete;
    }


    /**
     *
     * @return the $accessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

    /**
     *
     * @param AccessConfigSet $accessConfigSet
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;
    }

}
