<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Notification
 *
 * @ORM\Table(
 *     name="notification",
 *     indexes={
 *         @ORM\Index(name="fk_notification_logical_connection_idx", columns={"logical_connection_id"})
 *     }
 * )
 * @ORM\Entity
 */
class Notification extends AbstractDataObject
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
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     *
     * @Groups({"export"})
     */
    protected $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="success", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $success;

    /**
     * @var boolean
     *
     * @ORM\Column(name="failure", type="boolean", nullable=true)
     *
     * @Groups({"export"})
     */
    protected $failure;

    /**
     * @var LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection", inversedBy="notifications")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    protected $logicalConnection;

    /**
     * @param integer $id
     *
     * @return Notification
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
     * @param string $email
     *
     * @return Notification
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param boolean $success
     *
     * @return Notification
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param boolean $failure
     *
     * @return Notification
     */
    public function setFailure($failure)
    {
        $this->failure = $failure;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * @param LogicalConnection $logicalConnection
     *
     * @return Notification
     */
    public function setLogicalConnection(LogicalConnection $logicalConnection = null)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * @return LogicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

}
