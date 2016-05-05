<?php
namespace DbSystel\DataObject;

class Notification extends AbstractDataObject
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
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
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
     * @return the $success
     */
    public function getSuccess()
    {
        return $this->success;
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
     * @return the $failure
     */
    public function getFailure()
    {
        return $this->failure;
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
     * @return the $logicalConnection
     */
    public function getLogicalConnection()
    {
        return $this->logicalConnection;
    }

    /**
     *
     * @param LogicalConnection $logicalConnection            
     */
    public function setLogicalConnection($logicalConnection)
    {
        $this->logicalConnection = $logicalConnection;
    }

}