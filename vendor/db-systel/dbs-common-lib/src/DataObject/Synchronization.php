<?php
namespace DbSystel\DataObject;

/**
 * Synchronization
 *
 * @package DbSystel\DataObject
 */
class Synchronization extends AbstractDataObject
{

    const TYPE_APPLICATION = 'application';

    const TYPE_BILLING = 'billing';

    const TYPE_SERVER = 'server';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $inProgress;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $lastSync;

    /**
     * @param integer $id
     * @return Synchronization
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $inProgress
     * @return Synchronization
     */
    public function setInProgress($inProgress)
    {
        $this->inProgress = $inProgress;

        return $this;
    }

    /**
     * @return boolean $inProgress
     */
    public function getInProgress()
    {
        return $this->inProgress;
    }

    /**
     * @param string $type
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
     * @param integer $lastSync
     * @return Synchronization
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;

        return $this;
    }

    /**
     * @return integer $lastSync
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

}