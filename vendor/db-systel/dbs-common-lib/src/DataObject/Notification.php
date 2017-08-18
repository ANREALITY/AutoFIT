<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 */
class Notification extends AbstractDataObject
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var boolean
     */
    private $success;

    /**
     * @var boolean
     */
    private $failure;

    /**
     * @var LogicalConnection
     */
    private $logicalConnection;

    /**
     * @param integer $id
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
     * @return Notification
     */
    public function setLogicalConnection($logicalConnection)
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