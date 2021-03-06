<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * AccessConfig
 *
 * @ORM\Table(
 *     name="access_config",
 *     indexes={
 *         @ORM\Index(name="fk_access_config_access_config_set_idx", columns={"access_config_set_id"})
 *     }
 * )
 * @ORM\Entity
 */
class AccessConfig extends AbstractDataObject
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     *
     * @Groups({"export"})
     */
    protected $username;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_read", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $permissionRead;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_write", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $permissionWrite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_delete", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $permissionDelete;

    /**
     * @var AccessConfigSet
     *
     * @ORM\ManyToOne(targetEntity="AccessConfigSet", inversedBy="accessConfigs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     */
    protected $accessConfigSet;

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
    public function setAccessConfigSet(AccessConfigSet $accessConfigSet = null)
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
