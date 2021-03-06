<?php
namespace Base\DataObject;

use Doctrine\ORM\Mapping as ORM;
use Base\Annotation\Export;

/**
 * AuditLogCluster
 *
 * @ORM\Table(name="audit_log")
 * @ORM\Entity
 */
class AuditLogCluster extends AuditLog
{

    /**
     * @var Cluster
     *
     * @ORM\ManyToOne(targetEntity="Cluster")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    protected $cluster;

    /**
     * @param Cluster $cluster
     * @return AuditLogCluster
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
