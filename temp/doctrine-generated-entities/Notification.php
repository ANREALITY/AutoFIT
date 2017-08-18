<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification", indexes={@ORM\Index(name="fk_notification_logical_connection_idx", columns={"logical_connection_id"})})
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="success", type="boolean", nullable=true)
     */
    private $success;

    /**
     * @var boolean
     *
     * @ORM\Column(name="failure", type="boolean", nullable=true)
     */
    private $failure;

    /**
     * @var \LogicalConnection
     *
     * @ORM\ManyToOne(targetEntity="LogicalConnection")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logical_connection_id", referencedColumnName="id")
     * })
     */
    private $logicalConnection;



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
     * Set email
     *
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
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set success
     *
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
     * Get success
     *
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set failure
     *
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
     * Get failure
     *
     * @return boolean
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * Set logicalConnection
     *
     * @param \LogicalConnection $logicalConnection
     *
     * @return Notification
     */
    public function setLogicalConnection(\LogicalConnection $logicalConnection = null)
    {
        $this->logicalConnection = $logicalConnection;

        return $this;
    }

    /**
     * Get logicalConnection
     *
     * @return \LogicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }
}
