<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * AccessConfig
 *
 * @ORM\Table(name="access_config", indexes={@ORM\Index(name="fk_access_config_access_config_set_idx", columns={"access_config_set_id"})})
 * @ORM\Entity
 */
class AccessConfig
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=true)
     */
    private $username;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_read", type="boolean", nullable=true)
     */
    private $permissionRead;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_write", type="boolean", nullable=true)
     */
    private $permissionWrite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="permission_delete", type="boolean", nullable=true)
     */
    private $permissionDelete;

    /**
     * @var \AccessConfigSet
     *
     * @ORM\ManyToOne(targetEntity="AccessConfigSet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="access_config_set_id", referencedColumnName="id")
     * })
     */
    private $accessConfigSet;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
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
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set permissionRead
     *
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
     * Get permissionRead
     *
     * @return boolean
     */
    public function getPermissionRead()
    {
        return $this->permissionRead;
    }

    /**
     * Set permissionWrite
     *
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
     * Get permissionWrite
     *
     * @return boolean
     */
    public function getPermissionWrite()
    {
        return $this->permissionWrite;
    }

    /**
     * Set permissionDelete
     *
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
     * Get permissionDelete
     *
     * @return boolean
     */
    public function getPermissionDelete()
    {
        return $this->permissionDelete;
    }

    /**
     * Set accessConfigSet
     *
     * @param \AccessConfigSet $accessConfigSet
     *
     * @return AccessConfig
     */
    public function setAccessConfigSet(\AccessConfigSet $accessConfigSet = null)
    {
        $this->accessConfigSet = $accessConfigSet;

        return $this;
    }

    /**
     * Get accessConfigSet
     *
     * @return \AccessConfigSet
     */
    public function getAccessConfigSet()
    {
        return $this->accessConfigSet;
    }
}
