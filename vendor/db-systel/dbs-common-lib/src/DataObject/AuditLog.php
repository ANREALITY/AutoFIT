<?php
namespace DbSystel\DataObject;

class AuditLog extends AbstractDataObject
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
    protected $resuorceType;

    /**
     *
     * @var string
     */
    protected $resuorceId;

    /**
     *
     * @var string
     */
    protected $action;

    /**
     *
     * @var string
     */
    protected $eventDatetime;

    /**
     *
     * @var User
     */
    protected $user;

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
     * @return the $resuorceType
     */
    public function getResuorceType()
    {
        return $this->resuorceType;
    }

    /**
     *
     * @param string $resuorceType            
     */
    public function setResuorceType($resuorceType)
    {
        $this->resuorceType = $resuorceType;
    }

    /**
     *
     * @return the $resuorceId
     */
    public function getResuorceId()
    {
        return $this->resuorceId;
    }

    /**
     *
     * @param string $resuorceId            
     */
    public function setResuorceId($resuorceId)
    {
        $this->resuorceId = $resuorceId;
    }

    /**
     *
     * @return the $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     *
     * @param string $action            
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     *
     * @return the $eventDatetime
     */
    public function getEventDatetime()
    {
        return $this->eventDatetime;
    }

    /**
     *
     * @param string $eventDatetime            
     */
    public function setEventDatetime($eventDatetime)
    {
        $this->eventDatetime = $eventDatetime;
    }

    /**
     *
     * @return the $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

}