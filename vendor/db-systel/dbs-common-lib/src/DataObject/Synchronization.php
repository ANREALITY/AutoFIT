<?php
namespace DbSystel\DataObject;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synchronization
 *
 * @ORM\Table(
 *     name="synchronization",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="type_UNIQUE", columns={"type"})
 *     }
 * )
 * @ORM\Entity
 */
class Synchronization extends AbstractDataObject
{

    /** @var string */
    const TYPE_APPLICATION = 'application';
    /** @var string */
    const TYPE_BILLING = 'billing';
    /** @var string */
    const TYPE_SERVER = 'server';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="in_progress", type="boolean", nullable=false)
     */
    private $inProgress;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_sync", type="datetime", nullable=true)
     */
    private $lastSync;

    /**
     * @param integer $id
     *
     * @return Synchronization
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
     * @param boolean $inProgress
     *
     * @return Synchronization
     */
    public function setInProgress($inProgress)
    {
        $this->inProgress = $inProgress;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     * @param string $type
     *
     * @return Synchronization
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \DateTime $lastSync
     *
     * @return Synchronization
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

}
