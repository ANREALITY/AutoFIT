<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;
use DbSystel\Annotation\Export;

/**
 * AuditLogServer
 *
 * @ORM\Table(name="audit_log")
 * @ORM\Entity
 */
class AuditLogServer extends AuditLog
{

    /**
     * @var Server
     *
     * @ORM\ManyToOne(targetEntity="Server")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="name")
     */
    protected $server;

    /**
     * @param Server $server
     * @return AuditLogServer
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

}
