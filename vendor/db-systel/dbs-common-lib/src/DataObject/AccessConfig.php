<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessConfig
 */
class AccessConfig extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var boolean
     */
    private $permissionRead;

    /**
     * @var boolean
     */
    private $permissionWrite;

    /**
     * @var boolean
     */
    private $permissionDelete;

    /**
     * @var AccessConfigSet
     */
    private $accessConfigSet;

    /**
     * @param integer $id
     *
     * @return AccessConfig
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     *
     * @return AccessConfig
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param boolean $permissionRead
     *
     * @return AccessConfig
     */
    public function setPermissionRead($permissionRead)
    {
        $this->permissionRead = $permissionRead;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPermissionRead()
    {
        return $this->permissionRead;
    }

    /**
     * @param boolean $permissionWrite
     *
     * @return AccessConfig
     */
    public function setPermissionWrite($permissionWrite)
    {
        $this->permissionWrite = $permissionWrite;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPermissionWrite()
    {
        return $this->permissionWrite;
    }

    /**
     * @param boolean $permissionDelete
     *
     * @return AccessConfig
     */
    public function setPermissionDelete($permissionDelete)
    {
        $this->permissionDelete = $permissionDelete;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getPermissionDelete()
    {
        return $this->permissionDelete;
    }

    /**
     * @param AccessConfigSet $accessConfigSet
     *
     * @return AccessConfig
     */
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     * @return AccessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }

}
