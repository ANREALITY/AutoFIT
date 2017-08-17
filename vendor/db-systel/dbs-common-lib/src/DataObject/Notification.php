<?php
namespace DbSystel\DataObject;

class Notification extends AbstractDataObject
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
    protected $email;

    /**
     *
     * @var boolean
     */
    protected $success;

    /**
     *
     * @var boolean
     */
    protected $failure;

    /**
     *
     * @var LogicalConnection
     */
    protected $logicalConnection;

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
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     *
     * @return boolean $success
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     *
     * @param boolean $failure
     */
    public function setFailure($failure)
    {
        $this->failure = $failure;
    }

    /**
     *
     * @return boolean $failure
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     *
     * @param LogicalConnection $logicalConnection
     */
    public function setLogicalConnection($logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;
    }

    /**
     *
     * @return LogicalConnection $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

}