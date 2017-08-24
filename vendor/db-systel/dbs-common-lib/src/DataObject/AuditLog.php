<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuditLog
 *
 * @ORM\Table(
 *     name="audit_log",
 *     indexes={
 *         @ORM\Index(name="fk_audit_log_user_idx", columns={"user_id"})
 *     }
 * )
 * @ORM\Entity
 */
class AuditLog extends AbstractDataObject
{

    /** @var string */
    const RESSOURCE_TYPE_ORDER = 'order';
    /** @var string */
    const RESSOURCE_TYPE_SERVER = 'server';
    /** @var string */
    const RESSOURCE_TYPE_CLUSTER = 'cluster';
    /** @var string */
    const ACTION_ORDER_CREATED = 'order.created';
    /** @var string */
    const ACTION_ORDER_SUBMITTED = 'order.submitted';
    /** @var string */
    const ACTION_ORDER_EDITING_STARTED = 'order.editing_started';
    /** @var string */
    const ACTION_ORDER_UPDATED = 'order.updated';
    /** @var string */
    const ACTION_ORDER_CANCELED = 'order.canceled';
    /** @var string */
    const ACTION_ORDER_CHECKING_STARTED = 'order.checking_started';
    /** @var string */
    const ACTION_ORDER_ACCEPTED = 'order.accepted';
    /** @var string */
    const ACTION_ORDER_DECLINED = 'order.declined';
    /** @var string */
    const ACTION_ORDER_COMPLETED = 'order.completed';
    /** @var string */
    const ACTION_ORDER_EXPORTED = 'order.exported';
    /** @var string */
    const ACTION_SERVER_VIRTUAL_NODE_NAME_ADDED = 'server.virtual_node_name_added';
    /** @var string */
    const ACTION_CLUSTER_CREATED = 'cluster.created';

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
     * @ORM\Column(name="resource_type", type="string", nullable=true)
     */
    private $resourceType;

    /**
     * @var string
     *
     * @ORM\Column(name="resource_id", type="string", length=50, nullable=true)
     */
    private $resourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", nullable=true)
     */
    private $action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=false)
     */
    private $datetime;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @var FileTransferRequest
     */
    private $fileTransferRequest;

    /**
     * @var Server
     */
    private $server;

    /**
     * @var Cluster
     */
    private $cluster;

    /**
     * @param integer $id
     *
     * @return AuditLog
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
     * @param string $resourceType
     *
     * @return AuditLog
     */
    public function setResourceType($resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @param string $resourceId
     *
     * @return AuditLog
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * @return string
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param string $action
     *
     * @return AuditLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $datetime
     *
     * @return AuditLog
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param User $user
     *
     * @return AuditLog
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param FileTransferRequest $fileTransferRequest
     *
     * @return AuditLog
     */
    public function setFileTransferRequest(FileTransferRequest $fileTransferRequest)
    {
        $this->fileTransferRequest = $fileTransferRequest;

        return $this;
    }

    /**
     * @return FileTransferRequest
     */
    public function getFileTransferRequest()
    {
        return $this->fileTransferRequest;
    }

    /**
     * @param Server $server
     *
     * @return AuditLog
     */
    public function setServer(Server $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param Cluster $cluster
     *
     * @return AuditLog
     */
    public function setCluster(Cluster $cluster)
    {
        $this->cluster = $cluster;

        return $this;
    }

    /**
     * @return Cluster
     */
    public function getCluster()
    {
        return $this->cluster;
    }

}
