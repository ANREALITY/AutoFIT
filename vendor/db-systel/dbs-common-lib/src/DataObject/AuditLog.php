<?php
namespace DbSystel\DataObject;

class AuditLog extends AbstractDataObject
{

    const RESSOURCE_TYPE_ORDER = 'order';

    const RESSOURCE_TYPE_SERVER = 'server';

    const RESSOURCE_TYPE_CLUSTER = 'cluster';

    const ACTION_ORDER_CREATED = 'order.created';

    const ACTION_ORDER_SUBMITTED = 'order.submitted';

    const ACTION_ORDER_EDITING_STARTED = 'order.editing_started';

    const ACTION_ORDER_UPDATED = 'order.updated';

    const ACTION_ORDER_CANCELED = 'order.canceled';

    const ACTION_ORDER_CHECKING_STARTED = 'order.checking_started';

    const ACTION_ORDER_ACCEPTED = 'order.accepted';

    const ACTION_ORDER_DECLINED = 'order.declined';

    const ACTION_ORDER_COMPLETED = 'order.completed';

    const ACTION_ORDER_EXPORTED = 'order.exported';

    const ACTION_SERVER_VIRTUAL_NODE_NAME_ADDED = 'server.virtual_node_name_added';

    const ACTION_CLUSTER_CREATED = 'cluster.created';

    // Example code. Delete it!
    const ACTION_ORDER_FOO_BAR = 'foo.bar';

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