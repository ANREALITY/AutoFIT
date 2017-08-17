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

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $resourceType;

    /**
     *
     * @var string
     */
    protected $resourceId;

    /**
     *
     * @var string
     */
    protected $action;

    /**
     *
     * @var string
     */
    protected $datetime;

    /**
     *
     * @var User
     */
    protected $user;

    /**
     *
     * @var FileTransferRequest
     */
    protected $fileTransferRequest;

    /**
     *
     * @var Server
     */
    protected $server;

    /**
     *
     * @var Cluster
     */
    protected $cluster;

    /**
     *
     * @param number $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @param string $resourceType
     */
    public function setResourceType($resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    /**
     *
     * @return string $resourceType
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     *
     * @param string $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     *
     * @return string $resourceId
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     *
     * @param string $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     *
     * @return string $datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     *
     * @return User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param FileTransferRequest $fileTransferRequest
     */
    public function setFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequest = $fileTransferRequest;

        return $this;
    }

    /**
     *
     * @return FileTransferRequest $fileTransferRequest
     */
    public function getFileTransferRequest()
    {
        return $this->fileTransferRequest;
    }

    /**
     *
     * @param Server $server
     */
    public function setServer(Server $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     *
     * @return Server $server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     *
     * @param Cluster $cluster
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
    }

    /**
     *
     * @return Cluster $cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

}
